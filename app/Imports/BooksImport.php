<?php

namespace App\Imports;

use App\Models\Book;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

use Maatwebsite\Excel\Concerns\WithValidation;

class BooksImport implements ToCollection,WithValidation
{
//    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function Collection(Collection $row)
    {
        foreach ($row as $book) {
            Book::create([
                'title' => $book['0'],
                'author' => auth()->id(),
                'description' => $book['1'],
                'bio'=>$book['2'],
                'published_at'=>Date::excelToDateTimeObject($book['3']),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '0' => 'required|string|min:2|max:100', //title
            '1' => 'required|string|min:5|max:500', //desc
            '2' => 'required|string|min:5|max:500', //bio
            '3'=>'required' //published_at
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            // Title validation messages
            '0.required' => 'The title is required.',
            '0.string' => 'The title must be a string.',
            '0.min' => 'The title must be at least 2 characters long.',
            '0.max' => 'The title may not be greater than 100 characters.',

            // Description validation messages
            '1.required' => 'The description is required.',
            '1.string' => 'The description must be a string.',
            '1.min' => 'The description must be at least 5 characters long.',
            '1.max' => 'The description may not be greater than 500 characters.',

            // Bio validation messages
            '2.required' => 'The bio is required.',
            '2.string' => 'The bio must be a string.',
            '2.min' => 'The bio must be at least 5 characters long.',
            '2.max' => 'The bio may not be greater than 500 characters.',

            // Published_at validation messages
            '3.required' => 'The published_at date is required.',
//            '3.date' => 'The published_at must be a valid date.',
        ];
    }

}
