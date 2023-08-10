<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AdminController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('Admin');
    }

    public function index()
    {
        $cuser = Auth::user();
        $users=User::all();
        $page_title='Dashboard';
        return view('admin.home',compact('users','page_title','cuser'));
    }
}
