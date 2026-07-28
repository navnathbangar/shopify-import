<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportRecord extends Model
{
    protected $guarded = [];

    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
