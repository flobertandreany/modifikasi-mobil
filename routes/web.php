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
})->name('home');

Route::middleware(['auth'])->group(function (){
    Route::get('/home', [HomeController::class, 'index'])->middleware('userAkses:user');
    Route::get('/admin', [AdminController::class, 'index'])->middleware('userAkses:admin')->name('admin.store.approval');
    Route::get('/store', [StoreController::class, 'index'])->middleware('userAkses:store')->name('store.home');
});

Route::middleware(['userAkses:admin'])->group(function (){
    Route::post('/store/approval/{id}', [AdminController::class, 'approvalStore']);
    Route::post('/store/reject/{id}', [AdminController::class, 'rejectStore']);
    Route::get('store/list', [AdminController::class, 'viewStoreList'])->name('view.store.list');
    Route::get('car/model', [AdminController::class, 'carModelList'])->name('car.model.list');
    Route::get('car/brand', [AdminController::class, 'carBrandList'])->name('car.brand.list');
    Route::get('car/brand/form', [AdminController::class, 'carBrandForm'])->name('car.brand.form');
    Route::post('car/brand/create', [AdminController::class, 'addCarBrand'])->name('brand.create');
    Route::get('car/parts' , [AdminController::class, 'carPartList'])->name('car.part.list');
    // Route::get('/store/detail/{id}', [AdminController::class, 'getStoreDetail']);
    // Route::get('/store/approval', [StoreController::class, 'approval']);
    // Route::get('/store/approval/{id}', [StoreController::class, 'approvalStore']);
});

Route::middleware(['guest'])->group(function (){
    Route::get('/dashboard', [HomeController::class, 'index']);
    Route::get('/login', [LoginController::class, 'index'])->name('view.login');
    Route::get('/register', [RegisterController::class, 'formRegisterUser'])->name('view.register');
    Route::get('/register/store', [RegisterController::class, 'formRegisterStore'])->name('view.registerStore');
});

Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'postRegisterUser'])->name('register');
Route::post('/register/store', [RegisterController::class, 'postRegisterStore'])->name('registerStore');

Route::get('/store/city', [RegisterController::class, 'getCity'])->name('store.getCity');
Route::get('/store/district', [RegisterController::class, 'getDistrict'])->name('store.getDistrict');
Route::get('/store/subdistrict', [RegisterController::class, 'getSubdistrict'])->name('store.getSubdistrict');

Route::post('/store/edit/profile', [StoreController::class, 'editProfile'])->name('store.editProfile');

Route::get('users/{id}', function ($id) {
    return 'User '.$id;
});
