<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class PermitsControllers extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('FrontUsers');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cuser = Auth::user();
        $category=User::all();
        $page_title='Permits';
        return view('permits.permits',compact('category','page_title','cuser'));
    }
    public function create()
    {
        $cuser = Auth::user();
        $category = User::all();
        $page_title='New work permit request';
        return view('permits.create', compact('category','page_title','cuser'));
    }
}
