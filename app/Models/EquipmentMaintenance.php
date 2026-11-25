<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Equipment;

class EquipmentMaintenance extends Model
{
    public const MAINTENANCE_TYPES = [
        'Preventive',
        'Corrective',
        'Adaptive',
    ];

    protected $table = 'equipment_maintenance_history_table';

    protected $primaryKey = 'maintenance_id';

    protected $fillable = [
        'fk_equipment_id',
        'maintenance_date',
        'maintenance_type',
        'maintenance_description',
    ];

    protected function casts(): array
    {
        return [
            'maintenance_date' => 'date',
        ];
    }

    public function equipment()
    {
        return $this->belongsTo(
            Equipment::class,
            'fk_equipment_id',
            'equipment_id'
        );
    }
}