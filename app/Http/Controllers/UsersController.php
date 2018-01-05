<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller {

    public function __construct(){
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /**
     * all user list
     */
    public function index(){
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * show signup page
     * @return [type] [description]
     */
    public function create(){
        return view('users.create');
    }

    /**
     * create a new user
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        return redirect()->route('users.show', $user);
    }

    /**
     * show user info
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function show(User $user){
        return view('users.show', compact('user'));
    }

    /**
     * edit user info
     */
    public function edit(User $user){
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * update user info
     */
    public function update(User $user, Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('user.show', $user);
    }

    /**
     * admin delete user
     */
    public function destroy(User $user){
        $this->authorize('destroy', $user);
        $user->delete();
        return back();
    }
}
