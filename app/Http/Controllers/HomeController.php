<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

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
        $todos = Todo::get();
        foreach($todos as $key){ 
            $key['user'] = User::where('id',$key->user_id)->first(); // we can get colums one by one, but used "all()" instead
        }
        return view('todos.index',['todos'=>$todos]);

    }
}

