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
    Route::get('/user/delete/car/{id}', [UserController::class, 'deleteUserCar'])->name('user.deleteCar');
    Route::post('/user/update/car', [UserController::class, 'updateUserCar'])->name('user.updateCar');

    Route::post('/user/add/favorite', [UserController::class, 'addFavoriteProduct'])->name('user.addFavoriteProduct');
    Route::get('/user/remove/favorite', [UserController::class, 'removeFavoriteProduct'])->name('user.removeFavoriteProduct');
    Route::get('/user/favorite-list/', [UserController::class, 'viewFavoriteList'])->name('user.favoriteList');
    Route::get('/user/filter-favorite-list', [UserController::class, 'filterFavoriteList'])->name('user.filterFavoriteList');
});

Route::middleware(['userAkses:admin'])->group(function (){
    Route::get('/store/approval/{id}', [AdminController::class, 'approvalStore']);
    Route::get('/store/reject/{id}', [AdminController::class, 'rejectStore']);
    Route::post('/store/send-email-approval', [AdminController::class, 'sendEmailApproval'])->name('admin.sendEmailApproval');

    Route::get('store/list', [AdminController::class, 'viewStoreList'])->name('view.store.list');
    Route::get('store/delete/{id}', [AdminController::class, 'deleteStore'])->name('store.delete');
    Route::get('store/product/list/{id}', [AdminController::class, 'viewProductList'])->name('view.store.product.list');

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
    Route::get('car/parts/form', [AdminController::class, 'carPartForm'])->name('part.form');
    Route::post('car/parts/create', [AdminController::class, 'addCarPart'])->name('part.create');
    Route::get('car/parts/edit/{id}', [AdminController::class, 'editCarPart'])->name('part.edit');
    Route::post('car/parts/update/{id}', [AdminController::class, 'updateCarPart'])->name('part.update');
    Route::get('car/parts/delete/{id}', [AdminController::class, 'deleteCarPart'])->name('part.delete');

    Route::get('car/engine/', [AdminController::class, 'carEngineList'])->name('car.engine.list');
    Route::get('car/engine/form', [AdminController::class, 'carEngineForm'])->name('engine.form');
    Route::post('car/engine/create', [AdminController::class, 'addCarEngine'])->name('engine.create');
    Route::get('car/engine/edit/{id}', [AdminController::class, 'editCarEngine'])->name('engine.edit');
    Route::post('car/engine/update/{id}', [AdminController::class, 'updateCarEngine'])->name('engine.update');
    Route::get('car/engine/delete/{id}', [AdminController::class, 'deleteCarEngine'])->name('engine.delete');

    Route::post('/admin/edit/profile', [AdminController::class, 'editProfileAdmin'])->name('admin.editProfile');

});

Route::middleware(['userAkses:store'])->group(function (){
    Route::post('/store/edit/profile', [StoreController::class, 'editProfileStore'])->name('store.editProfile');

    Route::get('/store/product/form', [StoreController::class, 'productForm'])->name('store.productForm');
    Route::post('/store/product/create', [StoreController::class, 'addProduct'])->name('store.createProduct');
    Route::get('/store/product/edit/{type}/{id}', [StoreController::class, 'editProductForm'])->name('store.editProductForm');
    Route::post('/store/product/update/{id}', [StoreController::class, 'updateProduct'])->name('store.updateProduct');
    Route::get('/store/product/delete/{type}/{id}', [StoreController::class, 'deleteProduct'])->name('store.deleteProduct');

    Route::get('/store/car/model', [StoreController::class, 'getCarModel'])->name('store.getCarModel');
    Route::get('/store/car/year', [StoreController::class, 'getCarYear'])->name('store.getCarYear');
    Route::get('/store/car/engine', [StoreController::class, 'getCarEngine'])->name('store.getCarEngine');
    Route::get('/store/subcategory', [StoreController::class, 'getSubcategory'])->name('store.getSubcategory');
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
Route::get('/store/product/{imageName}', [StoreController::class, 'loadProductImage'])->name('store.productImage');
Route::get('/store/profile/{imageName}', [StoreController::class, 'loadProfileImage'])->name('store.profileImage');

Route::get('/user/brand', [UserController::class, 'carBrandList'])->name('user.carBrandList');
Route::get('/user/model', [UserController::class, 'carModelList'])->name('user.carModelList');
Route::get('/user/engine', [UserController::class, 'carEngineList'])->name('user.carEngineList');

Route::post('user/car', [UserController::class, 'addUserCar'])->name('user.addUserCar');
Route::get('car/brand/{imageName}', [AdminController::class, 'loadBrandImage'])->name('brand.image');

Route::get('/user/product-list/{type}/{name}', [UserController::class, 'viewUserProductList'])->name('user.productList');
Route::get('/user/filter-product-list', [UserController::class, 'filterProductList'])->name('user.filterProductList');
Route::get('/user/product-detail/{type}/{name}/{id}', [UserController::class, 'viewUserProductDetail'])->name('user.productDetail');
Route::get('/user/recommended-product', [UserController::class, 'getRecommendedProducts'])->name('user.recommendedProduct');
Route::get('/user/store/product/{imageName}', [UserController::class, 'loadProductImage'])->name('user.store.productImage');
Route::get('/user/store/detail/{id}', [UserController::class, 'viewStoreDetail'])->name('user.storeDetail');
Route::get('/user/store/filter-product-list', [UserController::class, 'filterStoreProductList'])->name('user.filterStoreProductList');
Route::get('/user/store/profile/{imageName}', [UserController::class, 'loadProfileImage'])->name('user.store.profileImage');

Route::get('/user/find-store-list', [UserController::class, 'viewFindStoreList'])->name('user.findStoreList');
Route::get('/user/filter-find-store', [UserController::class, 'filterFindStore'])->name('user.filterFindStore');
Route::get('/user/autocomplete-store', [UserController::class, 'loadAutocompleteStore'])->name('user.autocompleteStore');

Route::get('/user/product/search', [UserController::class, 'viewUserProductSearch'])->name('user.productSearch');
Route::get('/user/autocomplete-parts', [UserController::class, 'loadAutocompleteParts'])->name('user.autocompleteParts');

Route::get('users/{id}', function ($id) {
    return 'User '.$id;
});
