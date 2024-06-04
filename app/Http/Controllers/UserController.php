<?php

namespace App\Http\Controllers;

use App\Models\Car_brand;
use App\Models\Car_engine;
use App\Models\Car_model;
use App\Models\Favorite;
use App\Models\Modification;
use App\Models\Product;
use App\Models\Spareparts;
use App\Models\Store;
use App\Models\User;
use App\Models\User_car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{


    public function index(){

        $year = Car_model::select('car_year')->distinct()->orderBy('car_year', 'asc')->get();


        $mod = Modification::select('modifications.*', 'products.product_name as product_name', DB::raw("'modification' as type"))
            ->join('products', 'modifications.product_id', '=', 'products.id')
            ->inRandomOrder()->limit(8)->get();

        $spare = Spareparts::select('spareparts.*', 'products.product_name as product_name', DB::raw("'sparepart' as type"))
            ->join('products', 'spareparts.product_id', '=', 'products.id')
            ->inRandomOrder()->limit(8)->get();

        return view('home', [
            'year' => $year,
            'mod' => $mod,
            'sparepart' => $spare,
            'title' => 'Home',
            'nama' => 'Welcome, user!',
            'image' => 'Logo SpareCar.png',
        ]);
    }

    public function carBrandList(Request $request){
        Log::info($request->car_year);

        $carBrand = Car_brand::join('car_models', 'car_brands.id', '=', 'car_models.car_brand_id')
            ->where('car_models.car_year', $request->car_year)
            ->select('car_brands.id as id', 'car_brands.car_brand_name as car_brand_name', 'car_models.car_year as car_year')
            ->distinct()
            ->get();


        return $carBrand;
    }

    public function carModelList(Request $request){
        Log::info($request->brand_id);
        Log::info("ini car year " . $request->car_year);
        $carModel = Car_model::where('car_brand_id', $request->brand_id)
        ->where('car_year', $request->car_year)
        ->select('car_model_name', 'id')
        ->distinct()
        ->get();

        return $carModel;
    }

    public function addUserCar(Request $request){
        $userId = Session::get('user_id');
        $rules = [];
        Log::info($request->car_engine);
        if (!$userId) {
            // Redirect ke halaman login jika user_id tidak ditemukan
            return redirect()->route('view.login')->with('error', 'Please login first!');
        }


        $rules = array_merge($rules, [
            'car_engine' => [
                'required',
                Rule::unique('user_cars', 'car_engine_id')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }),
            ],
        ]);

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $is_active = User_car::where('user_id', $userId)->where('is_active', true)->first();
        if($is_active){
            $is_active->update([
                'is_active' => false,
            ]);
        }

        $brand = Car_brand::find($request->car_brand);
        $model = Car_model::find($request->car_model);
        $engine = Car_engine::find($request->car_engine);

        $car = new User_car();
        $car->user_id = $userId;
        $car->car_brand_id = $request->car_brand;
        $car->car_brand_logo = $brand->car_brand_logo;
        $car->car_model_id = $request->car_model;
        $car->car_model_name = $model->car_model_name;
        $car->car_year = $model->car_year;
        $car->car_engine_id = $request->car_engine;
        $car->car_engine_name = $engine->engine_name;
        $car->is_active = true;
        $car->save();

        return redirect()->back();
    }

    public function updateUserCar(Request $request){
        $userId = Session::get('user_id');

        $car = User_car::where('user_id', $userId)->where('is_active', true)->first();
        if($car){
            $car->update([
                'is_active' => false,
            ]);
        }
        $car_active = User_car::where('user_id', $userId)->where('id', $request->id)->first();
        if($car_active){
            $car_active->update([
                'is_active' => true,
            ]);
        }
        return redirect()->back();
    }

    public function deleteUserCar($id){
        $car = User_car::find($id);
        $car_active = User_car::where('user_id', Session::get('user_id'))->where('is_active', false)->first();

        if($car){
            $car->delete();
        }

        if($car_active){
            $car_active->update([
                'is_active' => true,
            ]);
        }

        return redirect()->back();
    }

    public function carEngineList(Request $request){
            Log::info($request->model_id);
            $carEngine = Car_engine::where('car_model_id', $request->model_id)
            ->select('engine_name', 'id')
            ->distinct()
            ->get();

            return $carEngine;
        }

    public function viewUserProductList($type, $name){
        if($type == 'sparepart'){
            $products = Spareparts::select(
                'spareparts.id as product_id',
                'spareparts.product_id as product_subcategory_id',
                'product_name as product_name',
                'sparepart_name as name',
                'sparepart_image as image',
                'sparepart_price as price',
                'sparepart_height as height',
                'sparepart_weight as weight',
                'description as description',
                'link_tokopedia as link_tokopedia',
                'link_shopee as link_shopee',
                'notes as notes',
                'spareparts.created_at as created_at',
                DB::raw("'sparepart' as type")
            )
            ->join('products', 'spareparts.product_id', '=', 'products.id')
            ->where('product_name', $name)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }else{
            $products = Modification::select(
                'modifications.id as product_id',
                'modifications.product_id as product_subcategory_id',
                'product_name as product_name',
                'mod_image as image',
                'mod_name as name',
                'mod_price as price',
                'mod_height as height',
                'mod_weight as weight',
                'description as description',
                'link_tokopedia as link_tokopedia',
                'link_shopee as link_shopee',
                'notes as notes',
                'modifications.created_at as created_at',
                DB::raw("'modification' as type")
            )
            ->join('products', 'modifications.product_id', '=', 'products.id')
            ->where('product_name', $name)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }

        return view('user.productList', [
            'title' => 'Product List',
            'products' => $products,
        ]);
    }

    public function filterProductList(Request $request){
        $query = null;
        $sort = $request->input('sort');
        $type = $request->input('type');
        $product_name = $request->input('product_name');

        if($type == 'sparepart'){
            $query = Spareparts::select(
                'spareparts.id as product_id',
                'spareparts.product_id as product_subcategory_id',
                'product_name as product_name',
                'sparepart_name as name',
                'sparepart_image as image',
                'sparepart_price as price',
                'sparepart_height as height',
                'sparepart_weight as weight',
                'description as description',
                'link_tokopedia as link_tokopedia',
                'link_shopee as link_shopee',
                'notes as notes',
                'spareparts.created_at as created_at',
                DB::raw("'sparepart' as type")
            )
            ->join('products', 'spareparts.product_id', '=', 'products.id')
            ->where('product_name', $product_name);
        } else {
            $query = Modification::select(
                'modifications.id as product_id',
                'modifications.product_id as product_subcategory_id',
                'product_name as product_name',
                'mod_image as image',
                'mod_name as name',
                'mod_price as price',
                'mod_height as height',
                'mod_weight as weight',
                'description as description',
                'link_tokopedia as link_tokopedia',
                'link_shopee as link_shopee',
                'notes as notes',
                'modifications.created_at as created_at',
                DB::raw("'modification' as type")
            )
            ->join('products', 'modifications.product_id', '=', 'products.id')
            ->where('product_name', $product_name);
        }

        switch ($sort) {
            case 'Newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'Oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'Highest Price':
                $query->orderBy('price', 'desc');
                break;
            case 'Lowest Price':
                $query->orderBy('price', 'asc');
                break;
            default:
                break;
        }

        $products = $query->paginate(10);

        return response()->json([
            'products' => $products->items(),
            'links' => (string) $products->links('vendor.pagination.bootstrap-5'),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'from_item' => $products->firstItem(),
                'to_item' => $products->lastItem(),
                'total' => $products->total()
            ]
        ]);
    }

    public function viewUserProductDetail($type, $name, $id){
        $userId = Session::get('user_id');
        $userCarId = User_car::where('user_id', $userId)->where('is_active', true)->value('id');

        if($type == 'sparepart'){
            $products = Spareparts::select(
                'spareparts.id as product_id',
                'spareparts.store_id as store_id',
                'spareparts.product_id as product_subcategory_id',
                'product_name as product_name',
                'sparepart_name as name',
                'sparepart_image as image',
                'sparepart_price as price',
                'sparepart_height as height',
                'sparepart_weight as weight',
                'description as description',
                'link_tokopedia as link_tokopedia',
                'link_shopee as link_shopee',
                'notes as notes',
                DB::raw("'sparepart' as type")
            )
            ->join('products', 'spareparts.product_id', '=', 'products.id')
            ->where('product_name', $name)
            ->where('spareparts.id', $id)
            ->first();

            $favoriteProduct = Favorite::select('user_car_id', 'part_id')
            ->where('user_car_id', $userCarId)
            ->where('part_id', $id)
            ->first();
        }else{
            $products = Modification::select(
                'modifications.id as product_id',
                'modifications.store_id as store_id',
                'modifications.product_id as product_subcategory_id',
                'product_name as product_name',
                'mod_image as image',
                'mod_name as name',
                'mod_price as price',
                'mod_height as height',
                'mod_weight as weight',
                'description as description',
                'link_tokopedia as link_tokopedia',
                'link_shopee as link_shopee',
                'notes as notes',
                DB::raw("'modification' as type")
            )
            ->join('products', 'modifications.product_id', '=', 'products.id')
            ->where('product_name', $name)
            ->where('modifications.id', $id)
            ->first();

            $favoriteProduct = Favorite::select('user_car_id', 'mod_id')
            ->where('user_car_id', $userCarId)
            ->where('mod_id', $id)
            ->first();
        }
        $store = Store::where('id', $products->store_id)->first();

        return view('user.productDetail', [
            'title' => 'Product Detail',
            'products' => $products,
            'store' => $store,
            'userId' => Session::get('user_id'),
            'favoriteProduct' => $favoriteProduct
        ]);
    }

    public function getRecommendedProducts(Request $request){
        $userId = Session::get('user_id');
        $type = $request->input('type');
        $product_name = $request->input('product_name');

        $userCar = User_car::select('car_model_id', 'car_engine_id','car_model_name', 'car_engine_name')
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->first();

        if($type == 'sparepart'){
            $products = Spareparts::select(
                'spareparts.id as product_id',
                'product_name as product_name',
                'sparepart_name as name',
                'sparepart_image as image',
                'sparepart_price as price',
                DB::raw("'sparepart' as type")
            )
            ->join('products', 'spareparts.product_id', '=', 'products.id')
            ->where('product_name', $product_name);

            if($userId){
                $products = $products->join('sparepart_details', 'spareparts.id', '=', 'sparepart_details.sparepart_id')
                ->where('car_model_id', $userCar->car_model_id)
                ->where('car_engine_id', $userCar->car_engine_id)
                ->addSelect(
                    DB::raw("'" . $userCar->car_model_name . "' as car_model_name"),
                    DB::raw("'" . $userCar->car_engine_name . "' as car_engine_name")
                );
            }
        }else{
            $products = Modification::select(
                'modifications.id as product_id',
                'product_name as product_name',
                'mod_name as name',
                'mod_image as image',
                'mod_price as price',
                DB::raw("'modification' as type")
            )
            ->join('products', 'modifications.product_id', '=', 'products.id')
            ->where('product_name', $product_name);

            if($userId){
                $products = $products->join('modification_details', 'modifications.id', '=', 'modification_details.modification_id')
                ->where('car_model_id', $userCar->car_model_id)
                ->where('car_engine_id', $userCar->car_engine_id)
                ->addSelect(
                    DB::raw("'" . $userCar->car_model_name . "' as car_model_name"),
                    DB::raw("'" . $userCar->car_engine_name . "' as car_engine_name")
                );
            }
        }

        $recommended_products = $products->inRandomOrder()->limit(10)->get();

        return response()->json([
            'products' => $recommended_products,
        ]);
    }

    public function addFavoriteProduct(Request $request){
        $userId = Session::get('user_id');
        $id = $request->input('id');
        $type = $request->input('type');

        $userCarId = User_car::where('user_id', $userId)->where('is_active', true)->value('id');

        if($type == 'sparepart'){
            $existFavorite = Favorite::select('user_car_id', 'part_id')
            ->where('user_car_id', $userCarId)
            ->where('part_id', $id)
            ->exists();

            if(!$existFavorite) {
                $favoriteInput = [
                    'user_car_id' => $userCarId,
                    'part_id' => $id,
                    'mod_id' => NULL,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                Favorite::create($favoriteInput);
            }
        }else{
            $existFavorite = Favorite::select('user_car_id', 'mod_id')
            ->where('user_car_id', $userCarId)
            ->where('mod_id', $id)
            ->exists();

            if(!$existFavorite) {
                $favoriteInput = [
                    'user_car_id' => $userCarId,
                    'part_id' => NULL,
                    'mod_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                Favorite::create($favoriteInput);
            }
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function removeFavoriteProduct(Request $request){
        $userId = Session::get('user_id');
        $id = $request->input('id');
        $type = $request->input('type');

        $userCarId = User_car::where('user_id', $userId)->where('is_active', true)->value('id');

        if($type == 'sparepart'){
            Favorite::select('user_car_id', 'part_id')
            ->where('user_car_id', $userCarId)
            ->where('part_id', $id)
            ->delete();
        }else{
            $existFavorite = Favorite::select('user_car_id', 'mod_id')
            ->where('user_car_id', $userCarId)
            ->where('mod_id', $id)
            ->delete();
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function viewFavoriteList(){
        $userId = Session::get('user_id');
        $userCarId = User_car::where('user_id', $userId)->where('is_active', true)->value('id');

        $spareparts = Spareparts::select(
            'spareparts.id as id',
            'product_name as product_name',
            'sparepart_name as name',
            'sparepart_image as image',
            'sparepart_price as price',
            'favorites.created_at as created_at',
            DB::raw("'sparepart' as type")
        )
        ->join('products', 'spareparts.product_id', '=', 'products.id')
        ->join('favorites', 'spareparts.id', '=', 'favorites.part_id')
        ->where('user_car_id', $userCarId);

        $modifications = Modification::select(
            'modifications.id as id',
            'product_name as product_name',
            'mod_name as name',
            'mod_image as image',
            'mod_price as price',
            'favorites.created_at as created_at',
            DB::raw("'modification' as type")
        )
        ->join('products', 'modifications.product_id', '=', 'products.id')
        ->join('favorites', 'modifications.id', '=', 'favorites.mod_id')
        ->where('user_car_id', $userCarId);

        $favorites = $spareparts->union($modifications)
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($favorites);
        return view('user.favoriteList', [
            'title' => 'Favorite List',
            'products' => $favorites,
        ]);
    }

    public function filterFavoriteList(Request $request){
        $userId = Session::get('user_id');
        $userCarId = User_car::where('user_id', $userId)->where('is_active', true)->value('id');
        $sort = $request->input('sort');

        $spareparts = Spareparts::select(
            'spareparts.id as id',
            'product_name as product_name',
            'sparepart_name as name',
            'sparepart_image as image',
            'sparepart_price as price',
            'favorites.created_at as created_at',
            DB::raw("'sparepart' as type")
        )
        ->join('products', 'spareparts.product_id', '=', 'products.id')
        ->join('favorites', 'spareparts.id', '=', 'favorites.part_id')
        ->where('user_car_id', $userCarId);

        $modifications = Modification::select(
            'modifications.id as id',
            'product_name as product_name',
            'mod_name as name',
            'mod_image as image',
            'mod_price as price',
            'favorites.created_at as created_at',
            DB::raw("'modification' as type")
        )
        ->join('products', 'modifications.product_id', '=', 'products.id')
        ->join('favorites', 'modifications.id', '=', 'favorites.mod_id')
        ->where('user_car_id', $userCarId);

        $query = $spareparts->union($modifications);

        switch ($sort) {
            case 'Newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'Oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'Highest Price':
                $query->orderBy('price', 'desc');
                break;
            case 'Lowest Price':
                $query->orderBy('price', 'asc');
                break;
            default:
                break;
        }

        $favoritesFilter = $query->get();

        return response()->json([
            'products' => $favoritesFilter
        ]);
    }

    public function viewStoreDetail($id){
        $store = Store::where('id', $id)->first();

        $menuSparepart = Product::where('product_category_id', 1)->get();
        $menuModification = Product::select('products.*', DB::raw("'modification' as type"))->where('product_category_id', 2)->get();

        $modifications = Modification::select(
            'modifications.id as id',
            'product_name as product_name',
            'product_id as product_id',
            'mod_name as name',
            'mod_image as image',
            'mod_price as price',
            'modifications.created_at as created_at',
            DB::raw("'modification' as type")
        )
        ->join('products', 'modifications.product_id', '=', 'products.id')
        ->where('store_id', $id);

        $spareparts = Spareparts::select(
            'spareparts.id as id',
            'product_name as product_name',
            'product_id as product_id',
            'sparepart_name as name',
            'sparepart_image as image',
            'sparepart_price as price',
            'spareparts.created_at as created_at',
            DB::raw("'sparepart' as type")
        )
        ->join('products', 'spareparts.product_id', '=', 'products.id')
        ->where('store_id', $id);

        $products = $modifications->union($spareparts)
        ->orderBy('created_at', 'desc')->paginate(12);

        return view('user.storeDetail', [
            'title' => 'Store Detail',
            'store' => $store,
            'part' => $menuSparepart,
            'mod' => $menuModification,
            'products' => $products,
        ]);
    }

    public function filterStoreProductList(){

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

    public function loadProfileImage($imageName){
        $imagePath = storage_path('app/imageProfile/' . $imageName);

        if (file_exists($imagePath)) {
            $file = Storage::disk('local')->get('imageProfile/' . $imageName);
            $type = mime_content_type($imagePath);
            return response($file, 200)->header('Content-Type', $type);
        } else {
            // Handle jika gambar tidak ditemukan
            abort(404);
        }
    }

    public function editProfileUser(Request $request){
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

        return redirect()->back()->with('success', 'User profile has been updated successfully.');
    }
}
