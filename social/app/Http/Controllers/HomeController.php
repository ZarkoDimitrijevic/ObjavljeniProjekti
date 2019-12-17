<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\post;//moramo da dodamo ovo - ukljucuje se model

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::get();
        var_dump($posts);
        return view('home');
    }
}
