<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class importBooksController extends Controller
{
    /**
     * Handle the incoming request.
     */
    use ApiResponseHelpers;
    public function __invoke(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
        DB::beginTransaction();
        try {


        Excel::import(new BooksImport,$request->file('file'));
        }catch (ValidationException  $e){
            DB::rollBack();
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row();
                $failure->attribute();
                $failure->errors();
                $failure->values();
            }

            return response()->json(['errors' => $failures], 422);
        }

        DB::commit();
        return $this->respondOk(__('app.file_uploaded_successfully'));
    }
}
