<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class CustomerController extends Controller
{
    public function importCustomers(Request $request)
    {

        try {
            $filename = 'customers.csv';
            $filePath = storage_path($filename);
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
