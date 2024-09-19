<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BooksExport implements FromCollection, WithColumnWidths, WithEvents
{
    public function __construct(public  $books)
    {
    }
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 25,
        ];
    }

    public function collection()
    {

        $data[] = [
            'id',
            'user',
            'title',
            'description',
            'bio',
            'published at',
        ];
        foreach ($this->books as  $book) {
            $data[] = [
                $book->id,
                $book->author?$book->author->name:'-',
                $book->title,
                $book->description,
                $book->bio,
                Carbon::make($book->published_at)->format('Y-m-d'),
            ];
        }
        return new Collection([
            $data
        ]);
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class=> function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A:Y')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
