<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Auth;
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
    if (!Auth::check()) {
        return redirect('/dashboard');
    }

    return redirect('/home');
});

Route::middleware(['auth'])->group(function (){
    Route::get('/home', [HomeController::class, 'index'])->middleware('userAkses:user');
    Route::get('/admin', [AdminController::class, 'index'])->middleware('userAkses:admin')->name('admin.store.approval');
    Route::get('/store', [StoreController::class, 'index'])->middleware('userAkses:store');
});

Route::middleware(['userAkses:admin'])->group(function (){
    Route::post('/store/approval/{id}', [AdminController::class, 'approvalStore']);
    // Route::get('/store/detail/{id}', [AdminController::class, 'getStoreDetail']);
    // Route::get('/store/approval', [StoreController::class, 'approval']);
    // Route::get('/store/approval/{id}', [StoreController::class, 'approvalStore']);
});

Route::middleware(['guest'])->group(function (){
    Route::get('/dashboard', [HomeController::class, 'index']);
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/register', [RegisterController::class, 'formRegisterUser']);
    Route::get('/register/store', [RegisterController::class, 'formRegisterStore'])->name('form.store');
});

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [RegisterController::class, 'postRegisterUser']);
Route::post('/register/store', [RegisterController::class, 'postRegisterStore']);


Route::get('users/{id}', function ($id) {
    return 'User '.$id;
});
