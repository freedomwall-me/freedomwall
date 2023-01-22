<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class IndexController extends BaseController
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
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

    public function profile()
    {
        // get walls of the user
        $walls = Auth::user()->walls()->orderBy('updated_date', 'desc')->paginate(20);
        return view('profile', ['walls' => $walls]);
    }
}
