<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Filters\BooksFilter;
use App\Models\Book;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportBooksController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, BooksFilter $filter)
    {
        $books = Book::latest()->filter($filter)->get();
        return Excel::download(new BooksExport($books),now()."-books.xlsx");

    }
}
