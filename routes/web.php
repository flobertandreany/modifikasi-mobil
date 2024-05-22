<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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
    Route::get('/home', [UserController::class, 'index'])->middleware('userAkses:user');
    Route::get('/admin', [AdminController::class, 'index'])->middleware('userAkses:admin')->name('admin.store.approval');
    Route::get('/store', [StoreController::class, 'index'])->middleware('userAkses:store')->name('store.productList');
});

Route::middleware(['userAkses:user'])->group(function (){
    Route::post('/user/edit/profile', [UserController::class, 'editProfileUser'])->name('user.editProfile');
});

Route::middleware(['userAkses:admin'])->group(function (){
    Route::get('/store/approval/{id}', [AdminController::class, 'approvalStore']);
    Route::get('/store/reject/{id}', [AdminController::class, 'rejectStore']);

    Route::get('store/list', [AdminController::class, 'viewStoreList'])->name('view.store.list');

    Route::get('car/model', [AdminController::class, 'carModelList'])->name('car.model.list');
    Route::get('car/model/form', [AdminController::class, 'carModelForm'])->name('model.form');
    Route::post('car/model/create', [AdminController::class, 'addCarModel'])->name('model.create');
    Route::get('car/model/edit/{id}', [AdminController::class, 'editCarModel'])->name('model.edit');
    Route::post('car/model/update/{id}', [AdminController::class, 'updateCarModel'])->name('model.update');
    Route::get('car/model/delete/{id}', [AdminController::class, 'deleteCarModel'])->name('model.delete');

    Route::get('car/brand', [AdminController::class, 'carBrandList'])->name('car.brand.list');
    Route::get('car/brand/form', [AdminController::class, 'carBrandForm'])->name('car.brand.form');
    Route::post('car/brand/create', [AdminController::class, 'addCarBrand'])->name('brand.create');
    Route::get('car/brand/edit/{id}', [AdminController::class, 'editCarBrand'])->name('brand.edit');
    Route::post('car/brand/update/{id}', [AdminController::class, 'updateCarBrand'])->name('brand.update');
    Route::get('car/brand/delete/{id}', [AdminController::class, 'deleteCarBrand'])->name('brand.delete');

    Route::get('car/parts' , [AdminController::class, 'carPartList'])->name('car.part.list');

    Route::post('/admin/edit/profile', [AdminController::class, 'editProfileAdmin'])->name('admin.editProfile');
    // Route::get('/store/detail/{id}', [AdminController::class, 'getStoreDetail']);
    // Route::get('/store/approval', [StoreController::class, 'approval']);
    // Route::get('/store/approval/{id}', [StoreController::class, 'approvalStore']);
});

Route::middleware(['userAkses:store'])->group(function (){
    Route::post('/store/edit/profile', [StoreController::class, 'editProfileStore'])->name('store.editProfile');
    Route::get('/store/profile/{imageName}', [StoreController::class, 'loadProfileImage'])->name('store.profileImage');

    Route::get('/store/product/form', [StoreController::class, 'productForm'])->name('store.productForm');
    Route::post('/store/product/create', [StoreController::class, 'addProduct'])->name('store.createProduct');
    Route::get('/store/product/edit/{type}/{id}', [StoreController::class, 'editProductForm'])->name('store.editProductForm');
    Route::post('/store/product/update/{id}', [StoreController::class, 'updateProduct'])->name('store.updateProduct');
    Route::get('/store/product/delete/{id}', [StoreController::class, 'deleteProduct'])->name('store.deleteProduct');

    Route::get('/store/car/brand', [StoreController::class, 'getCarBrand'])->name('store.getCarBrand');
    Route::get('/store/subcategory', [StoreController::class, 'getSubcategory'])->name('store.getSubcategory');
    Route::get('/store/product/{imageName}', [StoreController::class, 'loadProductImage'])->name('store.productImage');
});

Route::middleware(['guest'])->group(function (){
    Route::get('/dashboard', [UserController::class, 'index']);
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

Route::get('users/{id}', function ($id) {
    return 'User '.$id;
});
