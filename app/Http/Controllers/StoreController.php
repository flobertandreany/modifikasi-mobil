<?php

namespace App\Http\Controllers;

use App\Models\Car_brand;
use App\Models\Car_engine;
use App\Models\Car_model;
use App\Models\Modification;
use App\Models\ModificationDetail;
use App\Models\Product;
use App\Models\SparepartDetail;
use App\Models\Spareparts;
use App\Models\Store;
use App\Models\User;
use App\Rules\UniqueCarEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index(){
        $userId = Session::get('user_id');
        $storeId = Store::where('user_id', $userId)->value('id');

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
        ->where('store_id', $storeId);

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
        ->where('store_id', $storeId);

        $products = $modifications->union($spareparts)
        ->orderBy('created_at', 'desc')->paginate(5);
        // dd($products);

        return view('store.allProductList', [
            'title' => 'Product List',
            'products' => $products,
        ]);
    }

    public function editProfileStore(Request $request){
        // dd($request->file('filename'));
        $userId = Session::get('user_id');
        $storeId = $request->input('store_id');
        $rules = [];

        $rules = array_merge($rules, [
            'store_name' => 'required|min:5|max:255',
            'email' => 'required|email:dns',
            'store_phone' => 'required|starts_with:08|regex:/^(\d){10,}$/',
            'store_address' => 'required',
            'store_instagram' => 'required',
            'store_tokopedia' => 'required|url',
            'store_shopee' => 'required|url',
            'store_province' => 'required',
            'store_city' => 'required',
            'store_district' => 'required',
            'store_subdistrict' => 'required',
            'store_postal_code' => 'required|numeric',
            'filename' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
        ]);

        //cek ke database store by store name unique
        $store = Store::where('id', $storeId)->first();
        if($store->store_name != $request->store_name){
            $store_request = Store::where('store_name', $request->store_name)->first();
            if($store_request){
                // $errors['store_name'] = 'Store name already exists';
                $rules['store_name'] = 'required|min:5|max:255|unique:stores';
            }
        }

        //cek ke database store by phone unique
        if($store->store_phone != $request->store_phone){
            $store_request = Store::where('store_phone', $request->store_phone)->first();
            if($store_request){
                // $errors['store_phone'] = 'Phone number already exists';
                $rules['store_phone'] = 'required|starts_with:08|regex:/^(\d){10,}$/|unique:stores';
            }
        }

        //cek ke database user by email unique
        $user = User::where('id', $userId)->first();
        if($user->email != $request->email){
            $user_request = User::where('email', $request->email)->first();
            if($user_request){
                // $errors['email'] = 'Email already exists';
                $rules['email'] = 'required|email:dns|unique:users';
            }
        }

        $validator = Validator::make($request->all(), $rules);

        //balikin validasi pertama jika gagal
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Update failed. Please check your input.')->withInput();
        }

        $user = User::find($userId);
        $user->name = $request->store_name;
        $user->email = $request->email;
        $user->save();

        $store = Store::find($storeId);
        $store->store_name = $request->store_name;
        $store->store_phone = $request->store_phone;
        $store->store_address = $request->store_address;
        $store->store_instagram = $request->store_instagram;
        $store->store_tokopedia = $request->store_tokopedia;
        $store->store_shopee = $request->store_shopee;
        $store->store_province = $request->store_province;
        $store->store_city = $request->store_city;
        $store->store_district = $request->store_district;
        $store->store_subdistrict = $request->store_subdistrict;
        $store->store_postal_code = $request->store_postal_code;

        if($request->file('filename') == null){
            $store->save();
            return redirect()->back()->with('success', 'Store profile has been updated successfully.');
        }

        $oldImage = $store->store_logo;
        $imageName = !empty($request->file('filename')) ? $request->file('filename')->getClientOriginalName() : $oldImage;
        $newImage = $imageName;

        if (!empty($request->file('filename'))) {
            $newImage = uniqid() . '_' . $imageName;
            $request->file('filename')->move(storage_path('app/imageProfile'), $newImage);
        }

        $store->store_logo = $newImage;
        $store->save();

        if ($oldImage && $oldImage !== $newImage && !empty($request->file('filename'))) {
            unlink(storage_path('app/imageProfile/' . $oldImage));
        }

        return redirect()->back()->with('success', 'Store profile has been updated successfully.');
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

    public function productForm(){
        $car_brand = Car_brand::all();

        return view('store.addProduct', [
            'title' => 'Add Product',
            'car_brand' => $car_brand,
        ]);
    }

    public function addProduct(Request $request){
        // dd($request->all());
        $rules = [];
        $rules = [
            'product_category_id' => 'required',
            'product_subcategory_id' => 'required',
            'name'=> 'required',
            'description'=> 'required',
            'price'=> 'required|numeric',
            'weight'=> 'required|numeric',
            'height'=> 'required|numeric',
            'link_tokopedia' => 'required|url',
            'link_shopee' => 'required|url',
            'notes'=> 'required',
            'image_product' => 'required|image|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
        ];

        //aturan validasi untuk car_brand_id-* dan car_model_id-* secara dinamis
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'car_brand_id-') === 0) {
                $rules[$key] = 'required';
            }
            if (strpos($key, 'car_model_id-') === 0) {
                $rules[$key] = 'required';
            }
            if (strpos($key, 'car_year-') === 0) {
                $rules[$key] = 'required';
            }
            if (strpos($key, 'car_engine_id-') === 0) {
                $rules[$key] = 'required';
            }
        }
        $validatedData = $request->validate($rules);

        $carBrands = [];
        $carModels = [];
        $carYears = [];
        $carEngines = [];

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'car_brand_id-') === 0) {
                // Dapatkan indeks dengan memotong bagian string setelah "car_brand_id-"
                $index = substr($key, strlen('car_brand_id-'));
                $carBrands[$index] = $value;
            }
            if (strpos($key, 'car_model_id-') === 0) {
                $index = substr($key, strlen('car_model_id-'));
                $carModels[$index] = $value;
            }
            if (strpos($key, 'car_year-') === 0) {
                $index = substr($key, strlen('car_year-'));
                $carYears[$index] = $value;
            }
            if (strpos($key, 'car_engine_id-') === 0) {
                $index = substr($key, strlen('car_engine_id-'));
                $carEngines[$index] = $value;
            }
        }

        $productCategory = $request->input('product_category_id');
        $imageName = $request->file('image_product')->getClientOriginalName();
        $newImage = uniqid() . '_' . $imageName;
        $request->file('image_product')->move(storage_path('app/imageProduct'), $newImage);

        if($productCategory == 1){
            $sparepartInput = [
                'product_id' => $request->product_subcategory_id,
                'store_id' => $request->store_id,
                'sparepart_name'=> $request->name,
                'sparepart_image'=> $newImage,
                'sparepart_price'=> $request->price,
                'sparepart_weight'=> $request->weight,
                'sparepart_height'=> $request->height,
                'description'=> $request->description,
                'link_tokopedia' => $request->link_tokopedia,
                'link_shopee' => $request->link_shopee,
                'notes'=> $request->notes
            ];
            $sparepart = Spareparts::create($sparepartInput);

            $sparepartDetails = [];
            foreach ($carBrands as $index => $carBrand) {
                $carModels[$index] = Car_engine::where('id', $carEngines[$index])->value('car_model_id');
                // dd($carModels[$index]);
                $sparepartDetails[] = [
                    'sparepart_id' => $sparepart->id,
                    'car_brand_id' => $carBrand,
                    'car_model_id' => $carModels[$index],
                    'car_year' => $carYears[$index],
                    'car_engine_id' => $carEngines[$index],
                ];
            }
            SparepartDetail::insert($sparepartDetails);
        } else {
            $modificationInput = [
                'product_id' => $request->product_subcategory_id,
                'store_id' => $request->store_id,
                'mod_name'=> $request->name,
                'mod_image'=> $newImage,
                'mod_price'=> $request->price,
                'mod_weight'=> $request->weight,
                'mod_height'=> $request->height,
                'description'=> $request->description,
                'link_tokopedia' => $request->link_tokopedia,
                'link_shopee' => $request->link_shopee,
                'notes'=> $request->notes
            ];
            $modification = Modification::create($modificationInput);

            $modificationDetails = [];
            foreach ($carBrands as $index => $carBrand) {
                $carModels[$index] = Car_engine::where('id', $carEngines[$index])->value('car_model_id');

                $modificationDetails[] = [
                    'modification_id' => $modification->id,
                    'car_brand_id' => $carBrand,
                    'car_model_id' => $carModels[$index],
                    'car_year' => $carYears[$index],
                    'car_engine_id' => $carEngines[$index],
                ];
            }
            ModificationDetail::insert($modificationDetails);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function editProductForm($type, $id){
        $userId = Session::get('user_id');
        $storeId = Store::where('user_id', $userId)->value('id');

        if($type == 'sparepart'){
            $productCategory = 1;
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
                DB::raw("'sparepart' as type")
            )
            ->join('products', 'spareparts.product_id', '=', 'products.id')
            ->where('spareparts.id', $id)
            ->where('store_id', $storeId)->first();

            $productDetails = SparepartDetail::where('sparepart_id', $products->product_id)->get();
        }else{
            $productCategory = 2;
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
                DB::raw("'modification' as type")
            )
            ->join('products', 'modifications.product_id', '=', 'products.id')
            ->where('modifications.id', $id)
            ->where('store_id', $storeId)->first();

            $productDetails = ModificationDetail::where('modification_id', $products->product_id)->get();
        }

        $dataProductDetails = [];
        foreach ($productDetails as $p_detail) {
            $car_model_name = Car_model::where('id', $p_detail->car_model_id)->value('car_model_name');
            $car_year = Car_model::where('id', $p_detail->car_model_id)->value('car_year');
            $car_engine_name = Car_engine::where('car_model_id', $p_detail->car_model_id)->value('engine_name');
            $allCarModelName = Car_model::select('car_model_name')
                ->where('car_brand_id', $p_detail->car_brand_id)
                ->distinct()
                ->get();
            $allCarYear = Car_model::select('car_year')
                ->where('car_model_name', $car_model_name)
                ->distinct()
                ->get();
            $allCarEngine = Car_engine::select('id', 'engine_name')
                ->where('car_model_id', $p_detail->car_model_id)
                ->get();

            $p_detail->car_model_name = $car_model_name;
            $p_detail->car_engine_name = $car_engine_name;
            $p_detail->all_car_model = $allCarModelName;
            $p_detail->all_car_year = $allCarYear;
            $p_detail->all_car_engine = $allCarEngine;
            $dataProductDetails[] = $p_detail;
        }
        $car_brand = Car_brand::all();
        $productSubcategory = Product::where('product_category_id', $productCategory)->get();
        // dd($dataProductDetails);

        return view('store.editProduct', [
            'title' => 'Edit Product',
            'product_category_id' => $productCategory,
            'product_subcategory' => $productSubcategory,
            'products' => $products,
            'product_details' => $dataProductDetails,
            'car_brand' => $car_brand,
        ]);
    }

    public function updateProduct(Request $request, $id){
        // dd($request->all());
        $rules = [];
        $carBrands = [];
        $carModels = [];
        $carYears = [];
        $carEngines = [];

        $rules = [
            'product_subcategory_id' => 'required',
            'name'=> 'required',
            'description'=> 'required',
            'price'=> 'required|numeric',
            'weight'=> 'required|numeric',
            'height'=> 'required|numeric',
            'link_tokopedia' => 'required|url',
            'link_shopee' => 'required|url',
            'notes'=> 'required',
            'image_product' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
        ];

        //aturan validasi untuk car_brand_id-* dan car_model_id-* secara dinamis
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'car_brand_id-') === 0) {
                $rules[$key] = 'required';

                // ambil index untuk insert table dengan memotong bagian string setelah "car_brand_id-"
                $index = substr($key, strlen('car_brand_id-'));
                $carBrands[$index] = $value;
            }
            if (strpos($key, 'car_model_id-') === 0) {
                $rules[$key] = 'required';

                $index = substr($key, strlen('car_model_id-'));
                $carModels[$index] = $value;
            }
            if (strpos($key, 'car_year-') === 0) {
                $rules[$key] = 'required';

                $index = substr($key, strlen('car_year-'));
                $carYears[$index] = $value;
            }
            if (strpos($key, 'car_engine_id-') === 0) {
                $rules[$key] = [
                    'required',
                    new UniqueCarEngine($request->all(), $key)
                ];

                $index = substr($key, strlen('car_engine_id-'));
                $carEngines[$index] = $value;
            }
        }
        $validatedData = $request->validate($rules);

        $newImage = null;
        if(!empty($request->file('image_product'))){
            $imageName = $request->file('image_product')->getClientOriginalName();
            $newImage = uniqid() . '_' . $imageName;
            $request->file('image_product')->move(storage_path('app/imageProduct'), $newImage);
        }

        $productCategory = $request->input('product_category');
        if($productCategory == 1){
            $sparepart = Spareparts::find($id);
            $oldImage = $sparepart->sparepart_image;
            $sparepart->update([
                'product_id' => $request->product_subcategory_id,
                'sparepart_name' => $request->name,
                'sparepart_image'=> $newImage ?: $oldImage, // Gunakan gambar baru jika ada, jika tidak gunakan gambar lama
                'sparepart_price' => $request->price,
                'sparepart_weight' => $request->weight,
                'sparepart_height' => $request->height,
                'description' => $request->description,
                'link_tokopedia' => $request->link_tokopedia,
                'link_shopee' => $request->link_shopee,
                'notes' => $request->notes,
                'updated_at' => now()
            ]);

            SparepartDetail::where('sparepart_id', $sparepart->id)->delete();
            $sparepartDetails = [];
            foreach ($carBrands as $index => $carBrand) {
                $carModels[$index] = Car_engine::where('id', $carEngines[$index])->value('car_model_id');
                // dd($carModels[$index]);
                $sparepartDetails[] = [
                    'sparepart_id' => $sparepart->id,
                    'car_brand_id' => $carBrand,
                    'car_model_id' => $carModels[$index],
                    'car_year' => $carYears[$index],
                    'car_engine_id' => $carEngines[$index],
                    'updated_at' => now()
                ];
            }
            SparepartDetail::insert($sparepartDetails);
        } else {
            $modification = Modification::find($id);
            $oldImage = $modification->mod_image;
            $modification->update([
                'product_id' => $request->product_subcategory_id,
                'mod_name' => $request->name,
                'mod_image'=> $newImage ?: $oldImage,
                'mod_price' => $request->price,
                'mod_weight' => $request->weight,
                'mod_height' => $request->height,
                'description' => $request->description,
                'link_tokopedia' => $request->link_tokopedia,
                'link_shopee' => $request->link_shopee,
                'notes' => $request->notes,
                'updated_at' => now()
            ]);

            ModificationDetail::where('modification_id', $modification->id)->delete();
            $modificationDetails = [];
            foreach ($carBrands as $index => $carBrand) {
                $carModels[$index] = Car_engine::where('id', $carEngines[$index])->value('car_model_id');

                $modificationDetails[] = [
                    'modification_id' => $modification->id,
                    'car_brand_id' => $carBrand,
                    'car_model_id' => $carModels[$index],
                    'car_year' => $carYears[$index],
                    'car_engine_id' => $carEngines[$index],
                    'updated_at' => now()
                ];
            }
            ModificationDetail::insert($modificationDetails);
        }

        if ($oldImage && !empty($request->file('image_product'))) {
            unlink(storage_path('app/imageProduct/' . $oldImage));
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function deleteProduct($type, $id){
        if($type == 'sparepart'){
            $sparepart = Spareparts::find($id);
            SparepartDetail::where('sparepart_id', $sparepart->id)->delete();
            $sparepart->delete();

        } else {
            $modification = Modification::find($id);
            ModificationDetail::where('modification_id', $modification->id)->delete();
            $modification->delete();
        }
        return redirect()->route('store.productList');
    }

    public function getCarModel(Request $request){
        $car_model = Car_model::select('car_model_name')
        ->where('car_brand_id', $request->id)
        ->distinct('car_model_name')
        ->get();

        return $car_model;
    }

    public function getCarYear(Request $request){
        $car_year = Car_model::select('car_year')
        ->where('car_model_name', $request->car_model_name)
        ->distinct('car_model_name')
        ->get();

        return $car_year;
    }

    public function getCarEngine(Request $request){
        $car_engine = Car_engine::select('car_engines.id as id', 'engine_name')
        ->join('car_models', 'car_engines.car_model_id', '=', 'car_models.id')
        ->where('car_year', $request->car_year)
        ->where('car_model_name', $request->car_model_name)
        ->get();

        return $car_engine;
    }

    public function getSubcategory(Request $request){
        $subcategory = Product::where('product_category_id', $request->id)->get();

        return $subcategory;
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
}
