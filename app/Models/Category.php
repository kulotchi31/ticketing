<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequestType;

class Category extends Model
{
    protected $table = 'category_table';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'category_code',
        'fk_request_type_id',
    ];

    public function requestType()
    {
        return $this->belongsTo(
            RequestType::class,
            'fk_request_type_id',
            'request_type_id'
        );
    }
}