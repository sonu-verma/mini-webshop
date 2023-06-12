<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function importProducts(Request $request)
    {

        try {
            $filename = 'products.csv';
            $filePath = storage_path($filename);
//            dd($filePath);
            if (!file_exists($filePath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            $data = Excel::toArray([], $filePath)[0];
            unset($data[0]);
            
            return response()->json($data);
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
