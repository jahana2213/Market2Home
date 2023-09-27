<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    
    public function sendResponse($result, $message)
    {
        $response = [
            'status' => "Success",
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

 
    public function sendError($message)
    {
        $response = [
            'status' => "Failed",
            'message' => $message,
        ];

        return response()->json($response);
    }
}
