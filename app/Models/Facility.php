<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NextMaintenancePrediction;

class Facility extends Model
{
    protected $table = 'facility_table';

    protected $primaryKey = 'facility_id';

    protected $fillable = [
        'facility_name',
        'date_establish',
        'fk_campus_id',
    ];

    public function campus()
    {
        return $this->belongsTo(
            Campus::class,
            'fk_campus_id',
            'campus_id'
        );
    }

    public function maintenanceHistories()
    {
        return $this->hasMany(
            FacilityMaintenance::class,
            'fk_facility_id',
            'facility_id'
        );
    }


    public function nextPrediction()
{
    return $this->hasOne(
        NextMaintenancePrediction::class,
        'fk_facility_id',
        'facility_id'
    );
}
}
