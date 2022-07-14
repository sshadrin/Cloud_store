<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class User extends Controller  //Создали контроллер User
{


    public function create(Request $request)  //метод создания строки таблицы в базе данных
    {
        $name = $request->get("name");  //переменные соответствующие полям таблицы в базе данных
        $email = $request->get("email");
        $password = $request->get("password");
        $role = $request->get("role");
        $object = new \App\Models\User();  //создаем новую строку в таблице
        $object->name = $name;
        $object->email = $email;
        $object->password = password_hash($password, PASSWORD_DEFAULT);
        $object->role = $role;
        $object->save();
    }


    public function read()  //метод вывода таблицы в браузер
    {
        $text = \App\Models\User::all();
        $array = $text->toArray();

        return var_dump($array);
    }


    public function readOne($id)  //метод вывода отдельной строки в формате json
    {

        $text = \App\Models\User::where('id', '=', $id)->findorFail($id);

        return $text;
    }


    public function search($email)  //метод вывода отдельной строки email введенного пользователя
    {

        $text = \App\Models\User::where('email', '=', $email)->first();
        if(!$text) {
            echo "email not exist";
        }

        return $text;
    }


    public function update(Request $request)  //метод изменения строки в таблице базе данных
    {
        $id = $request->get("id");
        $name = $request->get("name");
        $email = $request->get("email");
        $password = $request->get("password");
        $role = $request->get("role");

        \App\Models\User::findorFail($id)->update(["name" => $name, "email" => $email, "password" => $password, "role" => $role]);  //добавил проверку на id в если не существует выдаст код ответа 404
    }


    public function delete($id)  //метод удаления строки в таблице базе данных
    {
        \App\Models\User::where('id', '=', $id)->delete();
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


}
