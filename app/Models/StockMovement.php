<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';
    protected $primaryKey = 'movement_id';

    protected $fillable = [
        'fk_stock_id',
        'type',
        'quantity',
        'transaction_date',
        'remarks',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'fk_stock_id', 'stock_id');
    }
}