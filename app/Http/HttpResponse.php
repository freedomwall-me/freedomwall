<?php

namespace App\Http;

trait HttpResponse
{
    public function success($data = null, $message = null, $code = 200)
    {
        return response()->json(
            [
                "success" => true,
                "data" => $data,
                "message" => $message,
            ],
            $code
        );
    }

    public function error($message, $code)
    {
        return response()->json(
            [
                "success" => false,
                "message" => $message,
            ],
            $code
        );
    }
}
