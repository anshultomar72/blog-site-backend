<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request){
        $credentials = $request -> validate([
            'loginemail' => 'required',
            'loginpassword' => 'required'
        ]);
        if(auth() -> attempt(['email' => $credentials['loginemail'], 'password' => $credentials['loginpassword']])){
            $request -> session() -> regenerate();
        }
        return redirect('/');
    }
    
    public function logout(){
        auth() -> logout();
        return redirect('/');
    }

    public function  register(Request $request){
        $incomingFields = $request -> validate([
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200']
        ]);
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::create($incomingFields);
        auth() -> login($user);
        return redirect('/');
    }
}
