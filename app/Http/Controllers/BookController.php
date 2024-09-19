<?php

namespace App\Http\Controllers;

use App\Filters\BooksFilter;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\traits\UploadFileHelper;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{

    use ApiResponseHelpers , UploadFileHelper;

    /**
     * Display a listing of the resource.
     */
    public function index(BooksFilter $filter)
    {
//        books are restricted to current author using Global scope
        $books = Book::latest()->filter($filter)->get();

        return $this->respondWithSuccess([
            'books' => BookResource::collection($books)
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        DB::beginTransaction();
        try {

        $book = Book::create(array_merge($request->except('cover'),[
            'cover' => $this->uploadFile($request->file('cover'),'books_cover'),
        ]));

        }catch (\Exception $exception){
            DB::rollBack();
            return  $this->respondError($exception->getMessage());
        }
        DB::commit();
        return $this->respondCreated([
            'book' => BookResource::make($book),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return $this->respondWithSuccess([
            'book' => BookResource::make($book),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        DB::beginTransaction();
        try {

            $book->update(array_merge($request->except('cover'),[
                'cover' =>$request->hasFile('cover')
                    ? $this->updateFile($request->file('cover'),$book->cover,'books_cover')
                    : $book->cover,
            ]));

        }catch (\Exception $exception){
            DB::rollBack();
            return  $this->respondError($exception->getMessage());
        }
        DB::commit();
        return $this->respondWithSuccess([
            'book' => BookResource::make($book),
            'message'=>__('app.information_has_been_updated_successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $this->deleteFile($book->cover);
        $book->delete();
        return $this->respondWithSuccess([
            'message'=>__('app.information_has_been_deleted_successfully')
        ]);
    }
}
