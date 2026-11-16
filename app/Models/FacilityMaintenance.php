<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Facility;

class FacilityMaintenance extends Model
{
    protected $table = 'facility_maintenance_history_table';

    protected $primaryKey = 'maintenance_id';

    protected $fillable = [
        'fk_facility_id',
        'maintenance_date',
        'maintenance_type',
        'maintenance_description',
        'maintenance_cost',
    ];

    public function facility()
    {
        return $this->belongsTo(
            Facility::class,
            'fk_facility_id',
            'facility_id'
        );
    }
}