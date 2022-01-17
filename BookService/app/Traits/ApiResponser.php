<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponser
{
    //Api json success response
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data],$code);
    }

    // Api json erro response
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message,'code' => $code],$code);
    }
}