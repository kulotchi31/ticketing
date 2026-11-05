<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditLogs extends Model
{
     use HasFactory;

    // Point to your specific table name
    protected $table = 'auditlogs_table';

    // Point to your custom primary key
    protected $primaryKey = 'audit_id';

    /**
     * The attributes that are mass assignable.
     * Including fk_user_id here fixes the MassAssignmentException.
     */
    protected $fillable = [
        'fk_user_id',
        'target_id',
        'action_type',
        'payload',
        'transaction_date',
    ];

    /**
     * Categorize your data types so Laravel handles them correctly.
     */
    protected $casts = [
        'payload' => 'array', // This allows you to pass arrays in the Controller
        'transaction_date' => 'date',
    ];


      public function user()
    {
        return $this->belongsTo(
            User::class,
            'fk_user_id',
            'id'
        );
    }
}
