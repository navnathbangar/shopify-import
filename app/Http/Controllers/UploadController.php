<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use App\Jobs\ProcessCsvImportJob;

use App\Helpers\LogHelper;

class UploadController extends Controller
{
    public function index()
    {
        return view('uploads.index');
    }

    public function store(Request $request)
    {
        $request->validate([

            'file'=>'required|mimes:csv,txt|max:2048'

        ]);

        $file = $request->file('file');

        $fileName = time().'_'.$file->getClientOriginalName();

        $file->storeAs('imports',$fileName);

        $upload = Upload::create([
            'file_name'=>$fileName,
            'status'=>'pending'
        ]);

        

        //ProcessCsvImportJob::dispatch($upload);
        (new \App\Jobs\ProcessCsvImportJob($upload))->handle();

        return back()->with(

            'success',

            'CSV Uploaded Successfully.'

        );
    }
}