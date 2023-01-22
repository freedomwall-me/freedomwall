<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends WallController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home');
    }

    public function contact()
    {
        return view('contact');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function profile(){
        return view('profile');
    }
}
