<?php

namespace App\Http\Controllers;

use App\Http\HttpResponse;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    use HttpResponse;

    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function show()
    {
        return $this->success("Retrieved user details successfully.", [
            "user" => auth("sanctum")->user(),
        ]);
    }
}
