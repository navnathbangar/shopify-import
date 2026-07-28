<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $guarded = [];

    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }
}
