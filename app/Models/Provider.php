<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequestType;
use App\Models\User;

class Provider extends Model
{
    protected $table = "provider_table";

    protected $primary_key ="provider_id";

    protected $fillables = [
        "provider_name",
        "provider_code"
    ];



    public function RequestTypes()
    {
        return $this->hasMany(RequestType::class, 'fk_provider_id', 'provider_id');
    }

       public function users()
    {
        return $this->hasMany(
            User::class,
            'fk_provider_id',
            'provider_id'
        );
    }




}
