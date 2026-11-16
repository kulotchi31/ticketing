<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;

use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StockProviderController extends Controller
{
    /**
     * Resolve the logged-in user's campus and provider (BMGS / MIS).
     */
    private function getProviderScope(): array
    {
        $user = Auth::user()->loadMissing(['department', 'provider']);

        $campus = $user->department?->campus_name
            ?? $user->department?->campus
            ?? $user->campus_name
            ?? null;

        $providerId = $user->fk_provider_id;

        abort_if(empty($campus), 403, 'No campus assigned to your department.');
        abort_if(empty($providerId), 403, 'No provider (BMGS/MIS) assigned to your account.');

        return [
            'campus'        => $campus,
            'provider_id'   => $providerId,
            'provider_code' => strtoupper($user->provider?->provider_code ?? ''),
            'provider_name' => $user->provider?->provider_name ?? '',
        ];
    }

    /**
     * Display the stocks monitoring page or return JSON for DataTables.
     */
    public function index(Request $request)
    {
        $scope = $this->getProviderScope();

        if ($request->ajax() || $request->wantsJson()) {
            $stocks = Stock::with(['campus', 'stockMovements'])
                ->where('fk_campus_id', $scope['campus'])
                ->where('fk_provider_id', $scope['provider_id'])
                ->orderByDesc('updated_at')
                ->get();

            return response()->json([
                'data'          => $stocks,
                'campus'        => $scope['campus'],
                'provider_code' => $scope['provider_code'],
            ]);
        }

        return view('provider.stocks', [
            'providerCode' => $scope['provider_code'],
            'providerName' => $scope['provider_name'],
            'campusName'   => $scope['campus'],
        ]);
    }

    /**
     * Store a new stock item automatically assigned to the user's campus and provider.
     */
    public function store(Request $request)
    {
        $scope = $this->getProviderScope();

        $validated = $request->validate([
            'item_name'     => [
                'required',
                'string',
                'max:255',
                Rule::unique('stocks')->where(function ($query) use ($scope) {
                    return $query->where('fk_campus_id', $scope['campus'])
                                 ->where('fk_provider_id', $scope['provider_id']);
                }),
            ],
            'sku'           => ['nullable', 'string', 'max:100'],
            'category'      => ['required', 'string', 'max:100'],
            'unit'          => ['required', 'string', 'max:50'],
            'quantity'      => ['required', 'integer', 'min:0'],
            'reorder_level' => ['required', 'integer', 'min:0'],
        ], [
            'item_name.unique' => 'This item already exists in your inventory.',
        ]);

        $validated['fk_campus_id']   = $scope['campus'];
        $validated['fk_provider_id'] = $scope['provider_id'];

        DB::transaction(function () use ($validated) {
            $stock = Stock::create($validated);

            if ($stock->quantity > 0) {
                StockMovement::create([
                    'fk_stock_id'      => $stock->stock_id,
                    'type'             => 'in',
                    'quantity'         => $stock->quantity,
                    'transaction_date' => now()->toDateString(),
                    'remarks'          => 'Initial opening stock balance.',
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock item added successfully.',
        ]);
    }

    /**
     * Update stock metadata (restricted to user's campus & provider).
     */
    public function update(Request $request, $id)
    {
        $scope = $this->getProviderScope();

        $stock = Stock::where('fk_campus_id', $scope['campus'])
            ->where('fk_provider_id', $scope['provider_id'])
            ->findOrFail($id);

        $validated = $request->validate([
            'item_name'     => [
                'required',
                'string',
                'max:255',
                Rule::unique('stocks')
                    ->ignore($stock->stock_id, 'stock_id')
                    ->where(function ($query) use ($scope) {
                        return $query->where('fk_campus_id', $scope['campus'])
                                     ->where('fk_provider_id', $scope['provider_id']);
                    }),
            ],
            'sku'           => ['nullable', 'string', 'max:100'],
            'category'      => ['required', 'string', 'max:100'],
            'unit'          => ['required', 'string', 'max:50'],
            'reorder_level' => ['required', 'integer', 'min:0'],
        ], [
            'item_name.unique' => 'This item already exists in your inventory.',
        ]);

        $stock->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Stock item updated successfully.',
        ]);
    }

    /**
     * Record a Stock In or Stock Out movement (restricted to user's campus & provider).
     */
    public function adjust(Request $request)
    {
        $scope = $this->getProviderScope();

        $validated = $request->validate([
            'fk_stock_id'      => ['required', 'exists:stocks,stock_id'],
            'type'             => ['required', Rule::in(['in', 'out'])],
            'quantity'         => ['required', 'integer', 'min:1'],
            'transaction_date' => ['required', 'date', 'before_or_equal:today'],
            'remarks'          => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated, $scope) {
            $stock = Stock::where('stock_id', $validated['fk_stock_id'])
                ->where('fk_campus_id', $scope['campus'])
                ->where('fk_provider_id', $scope['provider_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($validated['type'] === 'out' && $stock->quantity < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => ["Insufficient stock. Only {$stock->quantity} {$stock->unit} available."],
                ]);
            }

            if ($validated['type'] === 'in') {
                $stock->increment('quantity', $validated['quantity']);
            } else {
                $stock->decrement('quantity', $validated['quantity']);
            }

            StockMovement::create($validated);
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock movement recorded successfully.',
        ]);
    }

    /**
     * Delete a stock item and its movement logs (restricted to user's campus & provider).
     */
    public function destroy($id)
    {
        $scope = $this->getProviderScope();

        $stock = Stock::where('fk_campus_id', $scope['campus'])
            ->where('fk_provider_id', $scope['provider_id'])
            ->findOrFail($id);

        $stock->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stock item deleted successfully.',
        ]);
    }
}