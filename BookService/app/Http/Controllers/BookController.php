<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class BookController extends Controller
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

    public function index ()
    {
        $book = Book::all();

        return $this->successResponse($book);

    }

    public function store(Request $request) 
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $author = Book::create($request->all());

        return $this->successResponse($author,Response::HTTP_CREATED);

    }

    public function show($bookId)
    {
        $book = Book::findOrFail($bookId);

        return $this->successResponse($book);
    }


    public function update(Request $request,$bookId)
    {
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'min:1',
            'author_id' => 'min:1',
        ];

        $this->validate($request,$rules);

        $book = Book::findOrFail($bookId);

        $book->fill($request->all());

        if ($book->isClean()) {
            return $this->errorResponse('There is no change in any value',Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book->save();

        return $this->successResponse($book);

    }



    public function destroy($bookId)
    {
        $book = Book::findOrFail($bookId);

        $book->delete();

        return $this->successResponse($book);
    }
    //
}
