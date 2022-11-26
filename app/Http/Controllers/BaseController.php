<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    //for success response message
    public function sendResponse($code, $message, array $data = []) : object
    {
        $response = [
            'success' => true,
            'response_code' => $code,
            'message' => $message
        ];

        return response()->json(array_merge($response, $data));
    }

    //for error response message
    public function sendError($code, $error, array $errorMessages = []) : object
    {
        $response = [
            'success' => false,
            'response_code' => $code,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response);
    }
}
