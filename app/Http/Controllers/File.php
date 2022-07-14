<?php  //создаем контроллер для работы с файловой системой

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class File extends Controller
{

    public function create(Request $request)  //создать файл и директорию(или файл в директории)
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user_id') {
            $name = $request->get("name");
            $path = $request->file('file')->store($name, 'public');

            return $path;
        } else {
            echo "Your account does not have the necessary access!";
        }

    }


    public function read()  //вывести список всех файлов
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user_id') {
            $files = Storage::allFiles();

            return  var_dump($files);
        } else {
            echo "Your account does not have the necessary access!";
        }
    }


    public function readOne($id)  //вывести информацию о конкретном файле
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user_id') {
            echo asset('storage/' . $id);
        } else {
            echo "Your account does not have the necessary access!";
        }
    }


    public function update(Request $request)  //переименовать файл
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user_id') {
            $name = $request->get("name");
            $rename = $request->get("rename");
            rename(storage_path('app/public/upload/'. $name), storage_path('app/public/upload/'. $rename));
        } else {
            echo "Your account does not have the necessary access!";
        }
    }


    public function delete($id)  //удалить файл
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user_id') {
            unlink(storage_path('app/public/upload/'. $id));
        } else {
            echo "Your account does not have the necessary access!";
        }
    }


    public function createDir(Request $request)  //создать директорию
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user_id') {
            $directory = $request->get("name");
            Storage::makeDirectory("public/" . $directory);
        }  else {
            echo "Your account does not have the necessary access!";
        }
    }


    public function updateDir(Request $request)  //переименовать директорию
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user_id') {
            $name = $request->get("name");
            $rename = $request->get("rename");
            rename(storage_path('app/public/'. $name), storage_path('app/public/'. $rename));
        } else {
            echo "Your account does not have the necessary access!";
        }
    }


    public function readDir($id)  //вывести все файлы кокретной директории
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user_id') {
            $files = Storage::disk('public')->files($id);
            $files = Storage::disk('public')->allFiles($id);

            return $files;
        } else {
            echo "Your account does not have the necessary access!";
        }
    }


    public function deleteDir($id)  //удалить директорию
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user_id') {
            rmdir(storage_path('app/public/'. $id));
        } else {
            echo "Your account does not have the necessary access!";
        }
    }


    public function share($id)  //метод изменения роли в базе данных для права доступа работы с файлами
    {
        if (Auth::user()->role == 'admin') {
            $text = \App\Models\User::where('id', '=', $id)->update(["role" => "user_id"]);

            return $text;
        }
    }


    public function stopShare($id)  //метод изменения роли в базе данных для права доступа работы с файлами
    {
        if (Auth::user()->role == 'admin') {
            $text = \App\Models\User::where('id', '=', $id)->update(["role" => "user"]);

            return $text;
        }
    }


    public function vision()  //метод для просмотро какие пользователи обладают правом доступа
    {
        if (Auth::user()->role == 'admin') {
            $text = \App\Models\User::where('role', '=', "user_id")->get();

            return $text;
        }
    }


}
