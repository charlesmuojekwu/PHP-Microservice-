<?php

namespace App\Http\Controllers;

use App\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index() 
    {
        $authors = Author::all();

        return $this->successResponse($authors);
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::create($request->all());

        return $this->successResponse($author,Response::HTTP_CREATED);

    }


    public function show($authorId)
    {
        $author = Author::findOrFail($authorId);

        return $this->successResponse($author);
    }


    public function update(Request $request, $authorId)
    {
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255'
        ];

        $this->validate($request,$rules);

        $author = Author::findOrFail($authorId);

        $author->fill($request->all());

        if ($author->isClean()) {
            return $this->errorResponse('There is no change in any value',Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();

        return $this->successResponse($author);

    }

    public function destroy($authorId)
    {
        $author = Author::findOrFail($authorId);

        $author->delete();

        return $this->successResponse($author);
    }

    //
}
