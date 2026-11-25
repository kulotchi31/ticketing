<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NextEquipmentMaintenancePrediction extends Model
{
    protected $table = 'e_next_maintenance';

    protected $primaryKey = 'prediction_id';

    protected $fillable = [
        'fk_equipment_id',
        'last_maintenance_type',
        'last_maintenance_date',
        'predicted_next_action',
        'confidence',
        'predicted_date',
        'probabilities',
        'markov_probabilities',
        'model_used',
        'predicted_at',
    ];

    protected function casts(): array
    {
        return [
            'last_maintenance_date' => 'date',
            'predicted_date'        => 'date',
            'confidence'            => 'float',
            'probabilities'         => 'array',
            'markov_probabilities'  => 'array',
            'predicted_at'          => 'datetime',
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