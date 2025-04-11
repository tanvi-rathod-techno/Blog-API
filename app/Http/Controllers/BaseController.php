<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function sendResponse($response = null, $message = "", $status = true, $code = 0)
    {
        return response()->json([
            'code'     => $code,
            'status'   => $status,
            'message'  => $message,
            'response' => !empty($response) ? $response : (object) null
        ]);
    }

    protected function sendError($result = null, $message = "", $status = false, $code = 0)
    {
        return response()->json([
            'code'     => $code,
            'status'   => $status,
            'message'  => $message,
            'response' => !empty($result) ? $result : []
        ]);
    }
}
