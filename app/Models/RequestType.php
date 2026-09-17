<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Provider;
use App\Models\Category;

class RequestType extends Model
{
    protected $table="request_type_table";


    protected $primaryKey = 'request_type_id';


    protected $fillable = [
    'rt_name',
    'rt_code',
    'fk_provider_id'



    ];

       public function provider()
    {
        return $this->belongsTo(
            Provider::class,
            'fk_provider_id',
            'provider_id'
        );
    }


      public function categories()
    {
        return $this->hasMany(
            Category::class,
            'fk_request_type_id',
            'request_type_id'
        );
    }



}
