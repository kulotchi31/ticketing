<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';
    protected $primaryKey = 'stock_id';

    protected $fillable = [
        'fk_campus_id',
        'fk_provider_id',
        'item_name',
        'sku',
        'category',
        'unit',
        'quantity',
        'reorder_level',
    ];

    protected $casts = [
        'quantity'      => 'integer',
        'reorder_level' => 'integer',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'fk_campus_id', 'campus_name');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'fk_provider_id', 'provider_id');
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'fk_stock_id', 'stock_id')
            ->orderByDesc('transaction_date')
            ->orderByDesc('movement_id');
    }
}