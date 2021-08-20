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

        $todos = Todo::simplePaginate(2);

        $array['list'] = $todos->items();
        $array['paginas'] = $todos->currentPage();

        return $array;
    }

    public function readTodo($id)
    {
        $array = ['error' => ''];

        $todo = Todo::find($id);

        if($todo){
            $array['todo'] = $todo;
        }else{
            $array['error'] = 'A tarefa '.$id.' nao existe!!!';
        }

        return $array;
    }

    public function updateTodo($id, Request $request)
    {
        $array = ['error' => ''];

        //fazendo validação
        $rules = [
            'tittle' => 'min:3',
            'done' => 'boolean'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->getMessageBag();

            return $array;
        }

        $tittle = $request->input('tittle');
        $done = $request->input('done');

        //fazendo update no banco
        $todo = Todo::find($id);
        if($todo){

            if($tittle){
                $todo->tittle = $tittle;
            }
            if($done !== NULL){
                $todo->done = $done;
            }

            $todo->save();
        }else{
            $array['error'] = 'A tarefa '.$id.' não existe';
        }

        return $array;
    }

    public function deleteTodo($id)
    {
        $array = ['error' => ''];

        Todo::find($id)->delete();

        return $array;
    }

}
