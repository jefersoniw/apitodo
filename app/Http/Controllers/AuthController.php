<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function create(Request $request){
        $array = ['error' => ''];

        //validação
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ];

        $val = Validator::make($request->all(), $rules);

        if($val->fails()){

            $array['error'] = $val->getMessageBag();

            return $array;
        }

        //pegando dados
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->token = '';
        $user->save();

        return $array;
    }


    public function login(Request $request){
        $array = ['error' => ''];

        $creds = $request->only('email', 'password');

        $token = Auth::attempt($creds);

        if($token){

            $array['token'] = $token;
        } else {

            $array['error'] = 'Email e/ou Senha inválidos';
        }

        return $array;
    }


    public function logout(){
        $array = ['error' => ''];

        Auth::logout();

        return $array;
    }

    public function me(){
        $array = ['error' => ''];

        $me = Auth::user();

        $array['me'] = $me->email;

        return $array;
    }
}
