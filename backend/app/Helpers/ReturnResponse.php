<?php

namespace App\Helpers;

class ReturnResponse{

    public static function success($data = null)
    {
        return response()->json([
            'data' => $data,
            'status' => 'success'
        ], 200);
    }

    public static function error($data = null, $code = 400)
    {
        return response()->json([
            'data' => $data,
            'status' => 'failed'
        ], $code);
    }
}