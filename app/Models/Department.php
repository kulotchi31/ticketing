<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campus;
use App\Models\User;

class Department extends Model
{
    //

    protected $table = 'department_table';

    protected $primaryKey = 'department_id';


    protected $fillable = [
        'department_name',
        'department_code',
        'fk_campus_id',
    ];


    public function campus()
    {
        return $this->belongsTo(Campus::class, 'fk_campus_id', 'campus_id');
    }


      public function users()
    {
        return $this->hasMany(User::class);
    }
}
