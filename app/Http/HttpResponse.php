<?php

namespace App\Http;

trait HttpResponse
{
    public function success($message = null, $data = null, $code = 200)
    {
        return response()->json(
            [
                "message" => $message,
                "errors" => false,
                "data" => $data,
            ],
            $code
        );
    }

    public function error($message, $errors, $code)
    {
        return response()->json(
            [
                "message" => $message,
                "errors" => $errors,
            ],
            $code
        );
    }
}
