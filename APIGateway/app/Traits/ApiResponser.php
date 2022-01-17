<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponser
{
    //Api json success response
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response($data,$code)->header('content-type','application/json');
    }


    //Api json success response user
    public function validResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data],$code);
    }


    // Api Gateway json error response
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message,'code' => $code],$code);
    }

    public function errorMessage($message,$code)
    {
        return response($message,$code)->header('content-type','application/json');
    }
}