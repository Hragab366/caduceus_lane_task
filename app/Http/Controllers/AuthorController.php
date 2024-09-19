<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use PharIo\Manifest\Author;

class AuthorController extends Controller
{
    use ApiResponseHelpers;

    public function index()
    {
        $authors = User::role('Author')->get();
        return $this->respondWithSuccess([
            'authors' => AuthorResource::collection($authors)
        ]);
    }

    public function store(AuthorStoreRequest $request)
    {
        dd($request->all());
//        create author
        $author = User::create(array_merge($request->validated(), ['password' => bcrypt($request->password)]));
//        assign role as author
        $author->assignRole('Author');

        return $this->respondCreated([
            'author' =>AuthorResource::make($author)
        ]);
    }
    //
    public function update(AuthorUpdateRequest $request , User $user)
    {
       $data = $request->validated();

       if(array_key_exists('password', $data)){
           $data['password'] = bcrypt($data['password']);
       }

         $user->update($data);

       return $this->respondOk(__('app.information_has_been_updated_successfully'));
    }

    public function destroy(User $user)
    {
        $user->removeRole('Author');
        $user->delete();

        return $this->respondOk(__('app.information_has_been_deleted_successfully'));

    }
}
