<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\Car_brand;
use Illuminate\Support\Facades\Log;
use App\Models\Province;
use Illuminate\Http\Request;

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
        return view('admin.Car_model_list', [
            'title' => 'CAR MODEL LIST',
        ]);
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
            // 'r-type_brand_name' => 'required|same:car_brand_name',
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

    public function carPartList(){
        Log::info("Masuk ke dalam metode carPartList pada AdminController");
        return view('admin.Car_part_list', [
            'title' => 'CAR PART LIST',
        ]);
    }
}
