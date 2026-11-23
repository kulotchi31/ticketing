<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NextMaintenancePrediction extends Model
{
    protected $table = 'next_maintenance_predictions';

    protected $fillable = [
        'fk_facility_id',
        'last_maintenance_type',
        'last_maintenance_date',
        'predicted_next_action',
        'confidence',
        'probabilities',
        'model_used',
        'generated_at',
    ];

    protected $casts = [
        'last_maintenance_date' => 'date',
        'confidence' => 'float',
        'probabilities' => 'array',
        'generated_at' => 'datetime',
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