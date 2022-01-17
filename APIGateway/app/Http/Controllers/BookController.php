<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Book;
use App\Services\AuthorService;
use App\Services\BookService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class BookController extends Controller
{

    use ApiResponser;

    // The service to consume the Book microservice
    public $bookService;

    // The service to consume the Author microservice
    public $authorService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookServices, AuthorService $authorServices)
    {
        $this->bookService = $bookServices;
        $this->authorService = $authorServices;
    }

    public function index() 
    {
        return $this->successResponse($this->bookService->obtainBook());
    }


    public function store(Request $request)
    {
        $this->authorService->getAuthorById($request->author_id);

        return $this->successResponse($this->bookService->createBook($request->all(),Response::HTTP_CREATED));
    }


    public function show($bookId)
    {
        return $this->successResponse($this->bookService->getBookById($bookId));
    }


    public function update(Request $request, $bookId)
    {
        return $this->successResponse($this->bookService->updateBookById($request->all(),$bookId));
    }

    public function destroy($bookId)
    {
        return $this->successResponse($this->bookService->deleteBookById($bookId));
    }
    //
}
