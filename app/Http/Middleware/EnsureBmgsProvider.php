<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBmgsProvider
{
    public function handle(Request $request, Closure $next): Response
    {
        $providerId = (int) ($request->user()?->fk_provider_id ?? 0);

        if ($providerId !== 2) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Facility management is only available for BMGS providers.',
                ], 403);
            }

            abort(403, 'Facility management is only available for BMGS providers.');
        }

        return $next($request);
    }
}