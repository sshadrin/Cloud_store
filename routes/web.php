<?php  //создаем роут

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;
use App\Http\Controllers\admin;
use App\Http\Controllers\File;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get("/user", [User::class, "read"]);  //основная страница, отображает базу данных на данный момент
Route::get("/home",[User::class, "authenticate"]);
Route::get("/users/{id}", [User::class, "readOne"]);  //страница, отображает объект по id
Route::get("/user/search/{email}", [User::class, "search"]);  //страница, отображает email пользователя
Route::post("/user", [\App\Http\Controllers\User::class, "create"]);  //создает запись в базе данных
Route::put("/user", [User::class, "update"]);  //изменяет запись в базе данных
Route::delete("/user/{id}", [User::class, "delete"]);  //удаляет запись в базе данных

Route::get("/admin/user", [admin::class, "read"])->middleware("auth");  //отображает базу данных для админа
Route::get("/admin/users/{id}", [admin::class, "readOne"])->middleware("auth");  //страница, отображает объект по id для админа
Route::put("/admin/user", [admin::class, "update"])->middleware("auth");  //админ изменяет запись в базе данных
Route::delete("/admin/user/{id}", [admin::class, "delete"])->middleware("auth");  //админ удаляет запись в базе данных

Route::get("/file", [File::class, "read"])->middleware("auth");  //отображает все файлы в директориях
Route::get("/file/{id}", [File::class, "readOne"])->middleware("auth");  //отображает информацию по конкретному файлу
Route::post("/file", [File::class, "create"])->middleware("auth");  //создать файл и(в) директорию(и)
Route::put("/file", [File::class, "update"])->middleware("auth");  //переименовать файл
Route::delete("/file/{id}", [File::class, "delete"])->middleware("auth");  //удалить файл

Route::get("/directory/{id}", [File::class, "readDir"])->middleware("auth");  //информация о файлах конкретной директории
Route::post("/directory", [File::class, "createDir"])->middleware("auth");  //создать директорию
Route::put("/directory", [File::class, "updateDir"])->middleware("auth");  //переименовать директорию
Route::delete("/directory/{id}", [File::class, "deleteDir"])->middleware("auth");  //удалить директорию

Route::get("/files/share/{id}", [File::class, "share"])->middleware("auth");  //дает пользователю с id права доступа для работы с файлами
Route::get("/files/shares/{id}", [File::class, "stopShare"])->middleware("auth");  //отменяет право доступа
Route::get("/files/share", [File::class, "vision"])->middleware("auth");  //выводим всех пользователей с правом доступа

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');  //роут для аутентификации
