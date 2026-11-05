<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $table = 'status_history_table';

    protected $primaryKey = 'status_history_id';

    protected $fillable = [
        'ticket_id',
        'fk_user_id',
        'status',
        'remarks',
    ];

    public function ticket()
    {
        return $this->belongsTo(
            Ticket::class,
            'ticket_id',
            'ticket_id'
        );
    }

    public function worker()
    {
        return $this->belongsTo(
            User::class,
            'fk_user_id',
            'id'
        );
    }
}