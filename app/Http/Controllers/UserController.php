<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = User::paginate(5);
        return view('users.user',compact('user'));
    }

    public function fetch(Request $request){
        if($request->ajax()){
            $user = User::paginate(5);
            return view('pagination',compact('user'))->render();
        }
    }
}
