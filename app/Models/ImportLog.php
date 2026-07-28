<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    protected $fillable = [

        'upload_id',

        'product_id',

        'type',

        'message'

    ];
}
