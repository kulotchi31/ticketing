<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\EquipmentMaintenance;

class Equipment extends Model
{
    public const CATEGORIES = [
        'Network',
        'Computer Equipment',
        'Printing Equipment',
        'Multimedia Equipment',
        'Server and Storage',
        'Power and Accessories',
    ];

    public const STATUSES = [
        'operational',
        'needs_maintenance',
        'under_repair',
        'retired',
    ];

    protected $table = 'equipment_table';

    protected $primaryKey = 'equipment_id';

    protected $fillable = [
        'fk_department_id',
        'equipment_name',
        'category',
        'serial_number',
        'status',
        'date_acquired',
    ];

    protected function casts(): array
    {
        return [
            'date_acquired' => 'date',
        ];
    }

    public function department()
    {
        return $this->belongsTo(
            Department::class,
            'fk_department_id',
            'department_id'
        );
    }

    public function maintenanceHistories()
    {
        return $this->hasMany(
            EquipmentMaintenance::class,
            'fk_equipment_id',
            'equipment_id'
        );
    }


    public function nextPrediction()
{
    return $this->hasOne(
        NextEquipmentMaintenancePrediction::class,
        'fk_equipment_id',
        'equipment_id'
    );
}
}