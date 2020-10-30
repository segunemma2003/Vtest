<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/spa',function(){
    return view('entry');
});
Route::get('/test',function(){
    $last_id=\App\Models\User::latest()->first()->id;
        
    $user=\App\Models\User::create([
        "name"=>"segun",
        "email"=>"gm@a.com",
        "password"=>"2344",
        "referal_id"=>\Hashids::encode($last_id+1)
    ]);
});