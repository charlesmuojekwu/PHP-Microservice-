<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class AuthorService 
{
    use ConsumesExternalService;

    // base url to author service
    public $baseUri;

    // secret to consume author service
    public $secret;


    public function __construct()
    {
        $this->baseUri = config('services.authors.base_uri');
        $this->secret = config('services.authors.secret');
    }


    /// Fetch all Author 
    public function obtainAuthor()
    {
        return $this->performRequest('GET','/authors');
    }


    /// create new  Author
    public function createAuthor($data)
    {
        return $this->performRequest('POST','/authors',$data);
    }


    /// fetch single Author 
    public function getAuthorById($authorId)
    {
        return $this->performRequest('GET',"/authors/{$authorId}");
    }


    /// Update Author 
    public function updateAuthorById($data,$authorId)
    {
        return $this->performRequest('PUT',"/authors/{$authorId}",$data);
    }


    // delete author
    public function deleteAuthorById($authorId)
    {
        return $this->performRequest('delete',"/authors/{$authorId}");
    }


}