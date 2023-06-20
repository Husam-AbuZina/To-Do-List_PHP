<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('todos')->name('todos.')->group(function () {
    Route::get('index', [TodoController::class, 'index'])->name('index');
    Route::get('create', [TodoController::class, 'create'])->name('create');
    Route::post('store', [TodoController::class, 'store'])->name('store');
    Route::get('show/{id}', [TodoController::class, 'show'])->name('show');
    Route::get('{id}/edit', [TodoController::class, 'edit'])->name('edit');
    Route::put('update', [TodoController::class, 'update'])->name('update');
    Route::delete('destroy', [TodoController::class, 'destroy'])->name('destroy');

    //Route::resource('todos', TodoController::class); //resource Helper
});

// Route::prefix('todos')->name('todos.')->controller(TodoController::class)->group(function () {
// First line could be like this to make the code even shorter, But IDK why it does not working.
