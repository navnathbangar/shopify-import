<?php

namespace App\Helpers;

use App\Models\ImportLog;

class LogHelper
{
    public static function save($uploadId,$productId,$type,$message)
    {
        ImportLog::create([

            'upload_id'=>$uploadId,

            'product_id'=>$productId,

            'type'=>$type,

            'message'=>$message

        ]);
    }
}