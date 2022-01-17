<?php

namespace App\Http\Controllers;

use App\Author;
use App\Services\AuthorService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    use ApiResponser;

    // The service to consume the Author microservice
    public $authorService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthorService $authorServices)
    {
        $this->authorService = $authorServices;
    }

    public function index() 
    {
        return $this->successResponse($this->authorService->obtainAuthor());
    }


    public function store(Request $request)
    {
        
        return $this->successResponse($this->authorService->createAuthor($request->all(),Response::HTTP_CREATED));
    }


    public function show($authorId)
    {
        return $this->successResponse($this->authorService->getAuthorById($authorId));
    }


    public function update(Request $request, $authorId)
    {
        return $this->successResponse($this->authorService->updateAuthorById($request->all(),$authorId));
    }

    public function destroy($authorId)
    {
        return $this->successResponse($this->authorService->deleteAuthorById($authorId));
    }

    //
}
