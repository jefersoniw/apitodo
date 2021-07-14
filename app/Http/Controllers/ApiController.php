<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function createTodo(Request $request)
    {
        $array = ['error' => ''];

        //validação
        $rules = [
            'tittle' => 'required|min:3'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->getMessageBag();
          //$array['error'] = $validator->messages();
            return $array;
        }

        //fazendo inserção no banco
        $todo = new Todo();
        $todo->tittle = $request->input('tittle');
        $todo->save();

        return $array;
    }

    public function readAllTodos()
    {
        $array = ['error' => ''];

        $todos = Todo::all();

        $array['list'] = $todos;

        return $array;
    }

    public function readTodo()
    {

    }

    public function updateTodo()
    {

    }

    public function deleteTodo()
    {

    }

}
