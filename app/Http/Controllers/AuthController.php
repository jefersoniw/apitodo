<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
}
