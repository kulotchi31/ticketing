<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class Campus extends Model
{

    protected $table = 'campus_table';

    protected $primaryKey = 'campus_id';


    protected $fillable = [
        'campus_name',
        'campus_code',
    ];
  

    public function departments()
    {
        return $this->hasMany(Department::class, 'fk_campus_id', 'campus_id');
    }

}
