<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Upload;
use App\Models\ImportLog;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [

            'totalUploads' => Upload::count(),

            'totalProducts' => Product::count(),

            'successProducts' => Product::where('status','success')->count(),

            'failedProducts' => Product::where('status','failed')->count(),

            'processingProducts' => Product::where('status','processing')->count(),

            'updatedProducts' => Product::where('status','updated')->count(),

            'uploads' => Upload::latest()->paginate(10,['*'],'uploads_page'),

            'products' => Product::latest()->paginate(10,['*'],'products_page'),

        ];

        return view('dashboard.index',$data);
    }

    public function logs()
    {
        $logs = ImportLog::latest()->paginate(20);

        return view('logs.index', compact('logs'));
    }
}