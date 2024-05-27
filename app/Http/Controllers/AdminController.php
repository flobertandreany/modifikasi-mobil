<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\Car_brand;
use App\Models\Car_model;
use App\Models\Car_engine;
use App\Models\Product;
use App\Models\Spareparts;
use App\Models\Modification;
use App\Models\ModificationDetail;
use App\Models\SparepartDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(5);

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
            $store->store_code = date('dmy') . $store->user_id . $store->id . 'STR' . rand(100, 999);
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
            ->join('province', 'stores.store_province', '=', 'province.id')
            ->join('city', 'stores.store_city', '=', 'city.id')
            ->join('district', 'stores.store_district', '=', 'district.id')
            ->join('subdistrict', 'stores.store_subdistrict', '=', 'subdistrict.id')
            ->orderBy('stores.created_at', 'desc')
            ->select('stores.*', 'users.email as email', 'province.name as province_name', 'city.name as city_name', 'district.name as district_name', 'subdistrict.name as subdistrict_name')
            ->paginate(5);

        return view('admin.View_store_list', [
            'title' => 'STORE LIST',
            'store' => $store,
        ]);
    }

    public function deleteStore($id){
        Log::info("Masuk ke dalam metode deleteStore pada AdminController");
        $store = Store::find($id);

        if ($store) {
            $spareparts = Spareparts::where('store_id', $id)->get();
            foreach ($spareparts as $sparepart) {
                SparepartDetail::where('sparepart_id', $sparepart->id)->delete();
            }
            $modifications = Modification::where('store_id', $id)->get();
            foreach ($modifications as $modification) {
                ModificationDetail::where('modification_id', $modification->id)->delete();
            }

            $spareparts = Spareparts::where('store_id', $id)->delete();

            $modifications = Modification::where('store_id', $id)->delete();

            $store->delete();

            $user_id = $store->user_id;
            $user = User::find($user_id);
            $user->delete();
        }

        return redirect()->route('view.store.list');
    }

    public function viewProductList($id){
        Log::info("Masuk ke dalam metode viewProductList pada AdminController");

        $modifications = Modification::select(
            'modifications.id as id',
            'product_name as product_name',
            'mod_name as name',
            'mod_image as image',
            'mod_price as price',
            'mod_height as height',
            'mod_weight as weight',
            'modifications.created_at as created_at',
            DB::raw("'modification' as type")
        )
        ->join('products', 'modifications.product_id', '=', 'products.id')
        ->where('store_id', $id);

        $spareparts = Spareparts::select(
            'spareparts.id as id',
            'product_name as product_name',
            'sparepart_name as name',
            'sparepart_image as image',
            'sparepart_price as price',
            'sparepart_height as height',
            'sparepart_weight as weight',
            'spareparts.created_at as created_at',
            DB::raw("'sparepart' as type")
        )
        ->join('products', 'spareparts.product_id', '=', 'products.id')
        ->where('store_id', $id);

        $products = $modifications->union($spareparts)
        ->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.Store_product_list', [
            'title' => 'STORE PRODUCT',
            'products' => $products,
        ]);

    }

    public function loadProductImage($imageName){
        $imagePath = storage_path('app/imageProduct/' . $imageName);

        if (file_exists($imagePath)) {
            $file = Storage::disk('local')->get('imageProduct/' . $imageName);
            $type = mime_content_type($imagePath);
            return response($file, 200)->header('Content-Type', $type);
        } else {
            // Handle jika gambar tidak ditemukan
            abort(404);
        }
    }

    public function carModelList(){
        Log::info("Masuk ke dalam metode carModelList pada AdminController");

        $model = Car_model::join('car_brands', 'car_models.car_brand_id', '=', 'car_brands.id')
            ->orderBy('car_models.car_model_name', 'asc')
            ->select('car_models.*', 'car_brands.car_brand_name as brand_name')
            ->paginate(5);

        return view('admin.Car_model_list', [
            'title' => 'MANAGE CAR MODEL',
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

        $rules = [];

        $rules = array_merge($rules, [
            'car_brand' => 'required',
            'car_model_name' => 'required',
            'car_year' => 'required | numeric',
        ]);

        $model_car = Car_model::where('car_model_name', $request->car_model_name)
            ->where('car_year', $request->car_year)
            ->first();

        if($model_car){
            $rules['car_model_name'] = 'required|unique:car_models';
        }

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new Car_model;
        $model->car_brand_id = $request->car_brand;
        $model->car_model_name = $request->car_model_name;
        $model->car_year = $request->car_year;
        $model->save();

        return redirect()->route('car.model.list');
    }

    public function editCarModel($id){
        Log::info("Masuk ke dalam metode editCarModel pada AdminController");

        $model = Car_model::find($id);
        $brand = Car_brand::where('id', $model->car_brand_id)->select('car_brand_name')->first();

        return view('admin.Model_edit', [
            'title' => 'EDIT CAR MODEL',
            'brand' => $brand,
            'model' => $model,
        ]);
    }

    // if($request->engine_name == $engine->engine_name){
    //     $request->validate([
    //         'engine_name' => 'unique:car_engines',
    //     ]);

    // }

    public function updateCarModel(Request $request, $id){
        Log::info("Masuk ke dalam metode updateCarModel pada AdminController");
        $rules = [];

        $rules = array_merge($rules, [
            'car_brand' => 'required',
            'car_model_name' => 'required',
            'car_year' => 'required | numeric',
            'engine_name' => 'required',
        ]);

        $engine = Car_engine::where('car_model_id', $id)->first();
        if($engine->engine_name != $request->engine_name){
            $engine = Car_engine::where('engine_name', $request->engine_name)->first();
            if($engine){
                $rules['engine_name'] = 'required|unique:car_engines';
            }
        }

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
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

        Car_engine::where('car_model_id', $id)->delete();

        $model = Car_model::find($id);
        if($model){
            $model->delete();
        }

        return redirect()->route('car.model.list');
    }

    public function carBrandList(){
        Log::info("Masuk ke dalam metode carBrandList pada AdminController");

        $brand = Car_brand::orderBy('created_at', 'desc')->paginate(5);

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
        $request->file('car_brand_logo')->move(storage_path('app/brand_logo'), $imageName);

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

        $oldImage = $brand->car_brand_logo;
        $imageName = !empty($request->file('car_brand_logo')) ? $request->file('car_brand_logo')->getClientOriginalName() : $oldImage;
        $newImage = $imageName;

        if (!empty($request->file('car_brand_logo'))) {
            $newImage = uniqid() . '_' . $imageName;
            $request->file('car_brand_logo')->move(storage_path('app/brand_logo'), $newImage);
        }

        $brand->car_brand_logo = $imageName;
        $brand->save();

        if ($oldImage && $oldImage !== $newImage && !empty($request->file('car_brand_logo'))) {
            unlink(storage_path('app/brand_logo/' . $oldImage));
        }

        return redirect()->route('car.brand.list');
    }

    public function deleteCarBrand($id){
        Log::info("Masuk ke dalam metode deleteCarBrand pada AdminController");

        $carModels = Car_model::where('car_brand_id', $id)->get();

        foreach ($carModels as $carModel) {
            // Hapus semua engine terkait dengan setiap car_model
            Car_engine::where('car_model_id', $carModel->id)->delete();

            // Hapus car_model
            $carModel->delete();
        }

        $carBrand = Car_brand::find($id);
        if ($carBrand) {
            $carBrand->delete();
        }

        return redirect()->route('car.brand.list');
    }

    public function loadBrandImage($imageName){
        Log::info("Masuk ke dalam metode loadBrandImage pada AdminController");

        $path = storage_path('app/brand_logo/' . $imageName);
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function carEngineList(){
        $engine = Car_engine::join('car_models', 'car_engines.car_model_id', '=', 'car_models.id')
            ->join('car_brands', 'car_models.car_brand_id', '=', 'car_brands.id')
            ->orderBy('car_engines.created_at', 'asc')
            ->select('car_engines.*', 'car_models.car_model_name', 'car_brands.car_brand_name', 'car_models.car_year')
            ->paginate(5);

        return view('admin.Car_engine_list', [
            'title' => 'MANAGE CAR ENGINE',
            'engine' => $engine,
        ]);
    }

    public function carEngineForm(){
        Log::info("Masuk ke dalam metode carEngineForm pada AdminController");

        $year = Car_model::orderBy('car_year', 'asc')
                ->select('car_year')
                ->distinct()
                ->get();

        return view('admin.Engine_create', [
            'title' => 'ADD CAR ENGINE',
            'year'  => $year,
        ]);
    }

    public function carBrand(Request $request){
        Log::info($request->car_year);

        $carBrand = Car_brand::join('car_models', 'car_brands.id', '=', 'car_models.car_brand_id')
            ->where('car_models.car_year', $request->car_year)
            ->select('car_brands.id as id', 'car_brands.car_brand_name as car_brand_name', 'car_models.car_year as car_year')
            ->distinct()
            ->get();


        return $carBrand;
    }

    public function carModel(Request $request){
        Log::info($request->brand_id);
        Log::info($request->car_year);
        $carModel = Car_model::where('car_brand_id', $request->brand_id)
        ->where('car_year', $request->car_year)
        ->select('car_model_name', 'id')
        ->distinct()
        ->get();

        return $carModel;
    }

    public function carEngine(Request $request){
        Log::info($request->model_id);
        $carEngine = Car_engine::where('car_model_id', $request->model_id)
        ->select('engine_name', 'id')
        ->distinct()
        ->get();

        return $carEngine;
    }

    public function addCarEngine(Request $request){

        $rules = [];

        $rules = array_merge($rules, [
            'engine_name' => 'required',
        ]);

        $engine = Car_engine::where('car_model_id', $request->car_model)
            ->where('engine_name', $request->engine_name)
            ->first();

        if($engine){
            $rules['engine_name'] = 'required|unique:car_engines';
        }

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $engine = new Car_engine;
        $engine->car_model_id = $request->car_model;
        $engine->engine_name = $request->engine_name;
        $engine->save();

        return redirect()->route('car.engine.list');
    }

    public function editCarEngine($id){
        Log::info("Masuk ke dalam metode editCarEngine pada AdminController");

        $engine = Car_engine::find($id);
        $model = Car_model::where('id', $engine->car_model_id)->select('car_model_name', 'car_year')->first();
        $brand = Car_brand::join('car_models', 'car_brands.id', '=', 'car_models.car_brand_id')
            ->where('car_models.id', $engine->car_model_id)
            ->select('car_brands.car_brand_name')
            ->first();

        return view('admin.Engine_edit', [
            'title' => 'EDIT CAR ENGINE',
            'engine' => $engine,
            'model' => $model,
            'brand' => $brand,
        ]);
    }

    public function updateCarEngine(Request $request, $id){
        Log::info("Masuk ke dalam metode updateCarEngine pada AdminController");

        $rules = [];

        $rules = array_merge($rules, [
            'engine_name' => 'required',
        ]);

        $model = Car_model::where('car_year', $request->car_year)
            ->where('car_model_name', $request->car_model_name)
            ->first();

        $engine = Car_engine::find($id);
        if($engine->engine_name != $request->engine_name){
            if($model){
                $engine = Car_engine::where('engine_name', $request->engine_name)
                    ->where('car_model_id', $model->id)
                    ->first();
            }
            if($engine){
                $rules['engine_name'] = 'required|unique:car_engines';
            }
        }

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $engine = Car_engine::find($id);
        $engine->engine_name = $request->engine_name;
        $engine->save();

        return redirect()->route('car.engine.list');
    }

    public function deleteCarEngine($id){
        Log::info("Masuk ke dalam metode deleteCarEngine pada AdminController");

        $engine = Car_engine::find($id);
        if($engine){
            $engine->delete();
        }

        return redirect()->route('car.engine.list');
    }

    public function carPartList(){
        Log::info("Masuk ke dalam metode carPartList pada AdminController");

        $parts = Product::orderBy('created_at', 'asc')->paginate(5);

        return view('admin.Car_part_list', [
            'title' => 'MANAGE PARTS',
            'parts' => $parts,
        ]);
    }

    public function carPartForm(){
        Log::info("Masuk ke dalam metode carPartForm pada AdminController");

        return view('admin.Part_create', [
            'title' => 'ADD PART TYPE',
        ]);
    }

    public function addCarPart(Request $request){
        Log::info("Masuk ke dalam metode addCarPart pada AdminController");

        $request->validate([
            'part_type' => 'required',
            'part_name' => 'required|min:4',
        ]);

        $part = new Product;
        $part->product_category_id = $request->part_type;
        $part->product_name = $request->part_name;
        $part->save();

        return redirect()->route('car.part.list');
    }

    public function editCarPart($id){
        Log::info("Masuk ke dalam metode editCarPart pada AdminController");

        $part = Product::find($id);

        return view('admin.Part_edit', [
            'title' => 'EDIT PART TYPE',
            'part' => $part,
        ]);
    }

    public function updateCarPart(Request $request, $id){
        Log::info("Masuk ke dalam metode updateCarPart pada AdminController");

        $rules = [];

        $rules = array_merge($rules, [
            'part_type' => 'required',
            'product_name' => 'required|min:4',
        ]);

        $part = Product::find($id);
        if($part->product_name != $request->product_name){
            $part = Product::where('product_name', $request->product_name)->first();
            if($part){
                $rules['product_name'] = 'required|unique:products';
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $part = Product::find($id);
        $part->product_category_id = $request->part_type;
        $part->product_name = $request->part_name;
        $part->save();

        return redirect()->route('car.part.list');
    }

    public function deleteCarPart($id){
        Log::info("Masuk ke dalam metode deleteCarPart pada AdminController");

        Spareparts::where('product_id', $id)->delete();

        Modification::where('product_id', $id)->delete();

        $part = Product::find($id);
        if($part){
            $part->delete();
        }

        return redirect()->route('car.part.list');
    }
}
