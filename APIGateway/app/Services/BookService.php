<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class BookService 
{
    use ConsumesExternalService;

    // url to the book microservice
    public $baseUri;

    // secret to consume author service
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.books.base_uri');
        $this->secret = config('services.books.secret');
    }

        /// Fetch all Author 
        public function obtainBook()
        {
            return $this->performRequest('GET','/books');
        }
    
    
        /// create new  Author
        public function createBook($data)
        {
            return $this->performRequest('POST','/books',$data);
        }
    
    
        /// fetch single Author 
        public function getBookById($bookId)
        {
            return $this->performRequest('GET',"/books/{$bookId}");
        }
    
    
        /// Update Author 
        public function updateBookById($data,$bookId)
        {
            return $this->performRequest('PUT',"/books/{$bookId}",$data);
        }
    
    
        // delete author
        public function deleteBookById($bookId)
        {
            return $this->performRequest('delete',"/books/{$bookId}");
        }


}