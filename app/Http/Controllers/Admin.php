<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class admin extends Controller
{
    public function read()  //метод вывода таблицы в браузер только для зарегистрированного админа
    {
        if (Auth::user()->role == 'admin') {
            $text = \App\Models\User::all();
            $array = $text->toArray();
            return var_dump($array);
        } else {
            echo "This information for admin only";
        }
    }


    public function readOne($id)  //метод вывода отдельной строки в формате json только для зарегистрированного админа
    {
        if (Auth::user()->role == 'admin') {
            $text = \App\Models\User::where('id', '=', $id)->findorFail($id);
            return $text;
        } else {
            echo "This information for admin only";
        }
    }


    public function update(Request $request)  //метод изменения строки в таблице базе данных только для зарегистрированного админа
    {
        if (Auth::user()->role == 'admin') {
            $id = $request->get("id");
            $name = $request->get("name");
            $email = $request->get("email");
            $password = $request->get("password");
            $role = $request->get("role");
            \App\Models\User::findorFail($id)->update(["name" => $name, "email" => $email, "password" => $password, "role" => $role]);  //добавил проверку на id в если не существует выдаст код ответа 404
        } else {
            echo "This information for admin only";
        }
    }


    public function delete($id)  //метод удаления строки в таблице базе данных только для зарегистрированного админа
    {
        if (Auth::user()->role == 'admin') {
            \App\Models\User::where('id', '=', $id)->delete();
        }else {
            echo "This information for admin only";
        }
    }


}
