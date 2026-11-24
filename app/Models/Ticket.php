<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Department;
use App\Models\Category;
use App\Models\User;
use App\Models\Provider;

class Ticket extends Model
{
    protected $table = 'ticket_table';

    protected $primaryKey = 'ticket_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'ticket_number',
        'remarks',
        'fk_department_id',
        'fk_category_id',
        'created_by',
        'assign_to',
        'status',
        'classification',
        'is_walk_in',
        'acknowledge_by',
        'requested_by',
        'approved_by',
        'estimated_time',
        'pending_remarks',
        'action_taken'
    ];

    protected $casts = [
        'ticket_id' => 'integer',
        'fk_department_id' => 'integer',
        'fk_category_id' => 'integer',
        'created_by' => 'integer',
        'assign_to' => 'integer',
    ];

    public function department()
    {
        return $this->belongsTo(
            Department::class,
            'fk_department_id',
            'department_id'
        );
    }

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'fk_category_id',
            'category_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'id'
        );
    }

    public function assignee()
    {
        return $this->belongsTo(
            User::class,
            'assign_to',
            'id'
        );
    }

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by',
            'id'
        );
    }

    public function provider()
    {
        return $this->hasOneThrough(
            Provider::class,
            Category::class,
            'category_id',
            'provider_id', // adjust if your Provider primary key is 'id'
            'fk_category_id',
            'fk_provider_id' // adjust if Category links to provider via another foreign key
        );
    }
}