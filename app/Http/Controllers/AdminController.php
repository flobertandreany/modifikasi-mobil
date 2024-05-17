<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\Car_brand;
use App\Models\Car_model;
use App\Models\Car_engine;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(){
        Log::info("Masuk ke dalam metode index pada AdminController");
        $store = Store::whereNull('store_code')
            ->join('users', 'stores.user_id', '=', 'users.id')
            ->join('province', 'stores.store_province', '=', 'province.id')
            ->join('city', 'stores.store_city', '=', 'city.id')
            ->join('district', 'stores.store_district', '=', 'district.id')
            ->join('subdistrict', 'stores.store_subdistrict', '=', 'subdistrict.id')
            ->orderBy('stores.created_at', 'desc')
            ->select('stores.*', 'users.email as email', 'province.name as province_name', 'city.name as city_name', 'district.name as district_name', 'subdistrict.name as subdistrict_name')
            ->simplePaginate(5);

        return view('admin.Store_approval_list', [
            'title' => 'STORE APPROVAL LIST',
            'store' => $store,
        ]);
    }

    public function editProfileAdmin(Request $request){
        $userId = Session::get('user_id');
        $user = User::find($userId);
        $rules = [];

        $nameChanged = empty($request->input('name')) || $request->input('name') !== $user->name;
        $usernameChanged = empty($request->input('username')) || $request->input('username') !== $user->username;
        $emailChanged = empty($request->input('email')) || $request->input('email') !== $user->email;

        if ($nameChanged) {
            $rules = array_merge($rules, [
                'name' => 'required|unique:users|min:5|max:255',
            ]);
        } elseif ($usernameChanged) {
            $rules = array_merge($rules, [
                'username' => 'required|unique:users|min:5|max:255',
            ]);
        } elseif ($emailChanged) {
            $rules = array_merge($rules, [
                'email' => 'required|unique:users|email:dns',
            ]);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Update failed. Please check your input.');
        }

        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
        ]);

        return redirect()->back()->with('success', 'Admin profile has been updated successfully.');
    }

    public function approvalStore($id){
        Log::info("Masuk ke dalam metode approve");
        $store = Store::find($id);

        if ($store) {
            $store->store_code = 'STR' . date('dmy') . '_' . $store->user_id . $store->id . rand(100, 999);
            $store->save();
        }

        return redirect()->route('admin.store.approval');
    }

    public function rejectStore($id){
        Log::info("Masuk ke dalam metode rejectStore pada AdminController");
        $store = Store::find($id);

        if ($store) {
            $store->delete();

            $user_id = $store->user_id;
            $user = User::find($user_id);
            $user->delete();
        }

        return redirect()->route('admin.store.approval');
    }

    public function viewStoreList(){
        Log::info("Masuk ke dalam metode viewStoreList pada AdminController");
        $store = Store::whereNotNull('store_code')
            ->join('users', 'stores.user_id', '=', 'users.id')
            ->orderBy('stores.created_at', 'desc')
            ->select('stores.*', 'users.email')
            ->simplePaginate(3);

        return view('admin.View_store_list', [
            'title' => 'STORE LIST',
            'store' => $store,
        ]);
    }

    public function carModelList(){
        Log::info("Masuk ke dalam metode carModelList pada AdminController");

        $model = Car_model::join('car_brands', 'car_models.car_brand_id', '=', 'car_brands.id')
            ->join('car_engines', 'car_models.id', '=', 'car_engines.car_model_id')
            ->orderBy('car_models.car_model_name', 'asc')
            ->select('car_models.*', 'car_brands.car_brand_name as brand_name', 'car_engines.engine_name as engine_name')
            ->simplePaginate(5);

        return view('admin.Car_model_list', [
            'title' => 'CAR MODEL LIST',
            'model' => $model,
        ]);
    }

    public function carModelForm(){
        Log::info("Masuk ke dalam metode carModelForm pada AdminController");

        $brand = Car_brand::orderBy('car_brand_name', 'asc')->get();

        return view('admin.Model_create', [
            'title' => 'ADD CAR MODEL',
            'brand' => $brand,
        ]);
}

    public function addCarModel(Request $request){
        Log::info("Masuk ke dalam metode addCarModel pada AdminController");
        $request->validate([
            'car_brand' => 'required',
            'car_model_name' => 'required',
            'car_year' => 'required | numeric',
            'engine_name' => 'required | unique:car_engines',
        ]);

        $model = new Car_model;
        $model->car_brand_id = $request->car_brand;
        $model->car_model_name = $request->car_model_name;
        $model->car_year = $request->car_year;
        $model->save();

        $engine = new Car_engine;
        $engine->car_model_id = $model->id;
        $engine->engine_name = $request->engine_name;
        $engine->save();

        return redirect()->route('car.model.list');
    }

    public function editCarModel($id){
        Log::info("Masuk ke dalam metode editCarModel pada AdminController");

        $brand = Car_brand::orderBy('car_brand_name', 'asc')->get();
        $model = Car_model::find($id);
        $engine = Car_engine::where('car_model_id', $id)->first();

        return view('admin.Model_edit', [
            'title' => 'EDIT CAR MODEL',
            'brand' => $brand,
            'model' => $model,
            'engine' => $engine,
        ]);
    }

    // if($request->engine_name == $engine->engine_name){
    //     $request->validate([
    //         'engine_name' => 'unique:car_engines',
    //     ]);

    // }

    public function updateCarModel(Request $request, $id){
        Log::info("Masuk ke dalam metode updateCarModel pada AdminController");

        $errors = [];

        $request->validate([
            'car_brand' => 'required',
            'car_model_name' => 'required',
            'car_year' => 'required | numeric',
            'engine_name' => 'required',
        ]);

        $engine = Car_engine::where('car_model_id', $id)->first();

        if($engine->engine_name != $request->engine_name){
            $engine = Car_engine::where('engine_name', $request->engine_name)->first();

            if($engine){
                $errors['engine_name'] = 'The engine name has already been taken. Please choose a different name.';
                // return redirect()->back()->withErrors(['engine_name' => 'The engine name has already been taken. Please choose a different name.'])->withInput();
            }
        }

        if(!empty($errors)){
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $model = Car_model::find($id);
        $model->car_brand_id = $request->car_brand;
        $model->car_model_name = $request->car_model_name;
        $model->car_year = $request->car_year;
        $model->save();

        $engine = Car_engine::where('car_model_id', $id)->first();
        $engine->engine_name = $request->engine_name;
        $engine->save();

        return redirect()->route('car.model.list');
    }

    public function deleteCarModel($id){
        Log::info("Masuk ke dalam metode deleteCarModel pada AdminController");

        $engine = Car_engine::where('car_model_id', $id)->first();
        $engine->delete();

        $model = Car_model::find($id);
        $model->delete();

        return redirect()->route('car.model.list');
    }

    public function carBrandList(){
        Log::info("Masuk ke dalam metode carBrandList pada AdminController");

        $brand = Car_brand::orderBy('created_at', 'desc')->simplePaginate(5);

        return view('admin.Car_brand_list', [
            'title' => 'MANAGE CAR BRAND',
            'brand' => $brand,
        ]);
    }

    public function carBrandForm(){
        Log::info("Masuk ke dalam metode addCarBrandView pada AdminController");

        return view('admin.Brand_create', [
            'title' => 'ADD CAR BRAND',
        ]);
    }

    public function addCarBrand(Request $request){
        Log::info("Masuk ke dalam metode addCarBrand");

        $request->validate([
            'car_brand_name' => 'required',
            'car_brand_logo'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Log::info("Request: " . $request);

        $car_brand = new Car_brand;
        $car_brand->car_brand_name = $request->car_brand_name;

        $imageName = $request->file('car_brand_logo')->getClientOriginalName();
        $request->file('car_brand_logo')->move(public_path('img/brand'), $imageName);

        $car_brand->car_brand_logo = $imageName;
        $car_brand->save();

        Log::info("Berhasil menambahkan brand");

        return redirect()->route('car.brand.list');
    }

    public function editCarBrand($id){
        Log::info("Masuk ke dalam metode editCarBrand pada AdminController");

        $brand = Car_brand::find($id);

        return view('admin.Brand_edit', [
            'title' => 'EDIT CAR BRAND',
            'brand' => $brand,
        ]);
    }

    public function updateCarBrand(Request $request, $id){
        Log::info("Masuk ke dalam metode updateCarBrand pada AdminController");

        $request->validate([
            'car_brand_name' => 'required',
            'car_brand_logo'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = Car_brand::find($id);
        $brand->car_brand_name = $request->car_brand_name;

        if($request->file('car_brand_logo') == null){
            $brand->save();
            return redirect()->route('car.brand.list');
        }

        $imageName = $request->file('car_brand_logo')->getClientOriginalName();
        $request->file('car_brand_logo')->move(public_path('img/brand'), $imageName);

        $brand->car_brand_logo = $imageName;
        $brand->save();

        return redirect()->route('car.brand.list');
    }

    public function deleteCarBrand($id){
        Log::info("Masuk ke dalam metode deleteCarBrand pada AdminController");

        $brand = Car_brand::find($id);
        $brand->delete();

        return redirect()->route('car.brand.list');
    }

    public function carPartList(){
        Log::info("Masuk ke dalam metode carPartList pada AdminController");
        return view('admin.Car_part_list', [
            'title' => 'CAR PART LIST',
        ]);
    }
}
