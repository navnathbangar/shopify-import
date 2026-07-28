<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'file_name',
        'total_records',
        'processed_records',
        'successful_records',
        'failed_records',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function importRecords()
    {
        return $this->hasMany(ImportRecord::class);
    }

    public function errorLogs()
    {
        return $this->hasMany(ErrorLog::class);
    }
}
