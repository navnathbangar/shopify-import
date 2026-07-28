<?php

namespace App\Jobs;

use App\Imports\ShopifyProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\Upload;

class ProcessCsvImportJob implements ShouldQueue
{
    use Queueable;
    public $upload;

    
    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    
    public function handle(): void
    {
        try {

            $this->upload->update([
                'status' => 'processing'
            ]);

            Excel::import(
                new ShopifyProductImport($this->upload),
                storage_path('app/private/imports/'.$this->upload->file_name)
            );

        } catch (\Throwable $e) {       

            Log::error($e->getMessage());
            Log::error($e->getFile().' : '.$e->getLine());

            throw $e;
        }
    }
}
