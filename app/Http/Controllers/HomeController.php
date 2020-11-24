<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * Se especifica el guard reqres como middleware
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:reqres');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page=null)
    {
        $response = Http::get('https://reqres.in/api/products',[
            'page' => $page
        ]);
        $list = $response->body();
        
        return view('home')->with(compact('list'));
    }
}
