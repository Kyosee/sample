<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    /**
     * user login page
     * @return [type] [description]
     */
    public function create(){
        return view('sessions.create');
    }

    /**
     *  user login controller
     */
    public function store(Request $request){
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials), $request->has('remember')){
            return redirect()->route('users.show', Auth::user());
        }else{
            return redirect()->back();
        }
    }

    /**
     * user logout
     */
    public function destroy(){
        Auth::logout();
        return redirect()->route('login');
    }
}
