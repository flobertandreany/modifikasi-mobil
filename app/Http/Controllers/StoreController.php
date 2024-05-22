<?php

namespace App\Http\Controllers;

use App\Models\Car_brand;
use App\Models\Car_model;
use App\Models\Modification;
use App\Models\ModificationDetail;
use App\Models\Product;
use App\Models\SparepartDetail;
use App\Models\Spareparts;
use App\Models\Store;
use App\Models\User;
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

    public function test(Request $request)
    {
        $userId = Session::get('user_id');
        $user = User::find($userId);

        $storeId = $request->input('store_id');
        $store = Store::find($storeId);

        // Inisialisasi array untuk menyimpan aturan validasi
        $rules = [];

        // Cek perubahan pada form
        $storeNameChanged = empty($request->input('store_name')) || $request->input('store_name') !== $store->store_name;
        $storeEmailChanged = empty($request->input('email')) || $request->input('email') !== $user->email;
        $storePhoneChanged = empty($request->input('store_phone')) || $request->input('store_phone') !== $store->store_phone;
        $storeAddressChanged = empty($request->input('store_address'));
        $storeInstagramChanged = empty($request->input('store_instagram'));
        $storeTokopediaChanged = empty($request->input('store_tokopedia')) || $request->input('store_tokopedia') !== $store->store_tokopedia;
        $storeShopeeChanged = empty($request->input('store_shopee')) || $request->input('store_shopee') !== $store->store_shopee;
        $storeProvinceChanged = empty($request->input('store_province'));
        $storeCityChanged = empty($request->input('store_city'));
        $storeDistrictChanged = empty($request->input('store_district'));
        $storeSubdistrictChanged = empty($request->input('store_subdistrict'));
        $storePostalCodeChanged = empty($request->input('store_postal_code')) || $request->input('store_postal_code') !== $store->store_postal_code;
        $storeLogoChanged = $request->input('filename') !== $store->store_logo;

        // Aturan validasi hanya untuk field yang baru diubah
        if ($storeNameChanged) {
            $rules = array_merge($rules, [
                'store_name' => 'required|unique:stores|min:5|max:255',
            ]);
        } elseif ($storeEmailChanged) {
            $rules = array_merge($rules, [
                'email' => 'required|unique:users|email:dns',
            ]);
        } elseif ($storePhoneChanged) {
            $rules = array_merge($rules, [
                'store_phone' => 'required|unique:stores|starts_with:08|regex:/^(\d){10,}$/',
            ]);
        } elseif ($storeAddressChanged) {
            $rules = array_merge($rules, [
                'store_address' => 'required',
            ]);
        } elseif ($storeInstagramChanged) {
            $rules = array_merge($rules, [
                'store_instagram' => 'required',
            ]);
        } elseif ($storeTokopediaChanged) {
            $rules = array_merge($rules, [
                'store_tokopedia' => 'required|url',
            ]);
        } elseif ($storeShopeeChanged) {
            $rules = array_merge($rules, [
                'store_shopee' => 'required|url',
            ]);
        } elseif ($storeProvinceChanged) {
            $rules = array_merge($rules, [
                'store_province' => 'required',
                'store_city' => 'required',
                'store_district' => 'required',
                'store_subdistrict' => 'required',
            ]);
        } elseif ($storeCityChanged) {
            $rules = array_merge($rules, [
                'store_city' => 'required',
                'store_district' => 'required',
                'store_subdistrict' => 'required',
            ]);
        } elseif ($storeDistrictChanged) {
            $rules = array_merge($rules, [
                'store_district' => 'required',
                'store_subdistrict' => 'required',
            ]);
        } elseif ($storeSubdistrictChanged) {
            $rules = array_merge($rules, [
                'store_subdistrict' => 'required',
            ]);
        } elseif ($storePostalCodeChanged) {
            $rules = array_merge($rules, [
                'store_postal_code' => 'required|numeric',
            ]);
        } elseif ($storeLogoChanged) {
            $rules = array_merge($rules, [
                'filename' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
            ]);
        }

        // Validasi menggunakan array $rules yang diperoleh
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->withErrors($validator)->with('error', 'Update failed. Please check your input.');
        }

        $oldImage = $store->store_logo;
        $imageName = !empty($request->file('filename')) ? $request->file('filename')->getClientOriginalName() : $oldImage;
        $newImage = $imageName;

        if (!empty($request->file('filename'))) {
            $newImage = uniqid() . '_' . $imageName;
            $request->file('filename')->move(storage_path('app/imageProfile'), $newImage);
        }

        //Update tabel users
        $user->update([
            'name' => $request->input('store_name'),
            'email' => $request->input('email'),
        ]);

        // Update tabel stores
        $store->update([
            'store_name' => $request->input('store_name'),
            'store_phone' => $request->input('store_phone'),
            'store_address' => $request->input('store_address'),
            'store_instagram' => $request->input('store_instagram'),
            'store_tokopedia' => $request->input('store_tokopedia'),
            'store_shopee' => $request->input('store_shopee'),
            'store_province' => $request->input('store_province'),
            'store_city' => $request->input('store_city'),
            'store_district' => $request->input('store_district'),
            'store_subdistrict' => $request->input('store_subdistrict'),
            'store_postal_code' => $request->input('store_postal_code'),
            'store_logo'=> $newImage,
        ]);

        // Delete image di server
        if ($oldImage && $oldImage !== $newImage && !empty($request->file('filename'))) {
            unlink(storage_path('app/imageProfile/' . $oldImage));
        }

        return redirect()->back()->with('success', 'Store profile has been updated successfully.');
    }

    public function editProfileStore(Request $request){
        // dd($request->file('filename'));
        $userId = Session::get('user_id');
        $storeId = $request->input('store_id');
        $errors = [];

        $validator = Validator::make($request->all(), [
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

        //balikin validasi pertama jika gagal
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Update failed. Please check your input.')->withInput();
        }

        //cek ke database store by store name unique
        $store = Store::where('id', $storeId)->first();
        if($store->store_name != $request->store_name){
            $store_request = Store::where('store_name', $request->store_name)->first();
            if($store_request){
                $errors['store_name'] = 'Store name already exists';
            }
        }

        //cek ke database store by phone unique
        if($store->store_phone != $request->store_phone){
            $store_request = Store::where('store_phone', $request->store_phone)->first();
            if($store_request){
                $errors['store_phone'] = 'Phone number already exists';
            }
        }

        //cek ke database user by email unique
        $user = User::where('id', $userId)->first();
        if($user->email != $request->email){
            $user_request = User::where('email', $request->email)->first();
            if($user_request){
                $errors['email'] = 'Email already exists';
            }
        }

        //balikin validasi kedua jika gagal
        if(!empty($errors)){
            return redirect()->back()->withErrors($errors)->with('error', 'Update failed. Please check your input.')->withInput();
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
        }
        $validatedData = $request->validate($rules);

        $carBrands = [];
        $carModels = [];

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'car_brand_id-') === 0) {
                // Dapatkan indeks dengan memotong bagian string setelah "car_brand_id-"
                $index = substr($key, strlen('car_brand_id-'));
                $carBrands[$index] = $value;
            }
            if (strpos($key, 'car_model_id-') === 0) {
                // Dapatkan indeks dengan memotong bagian string setelah "car_model_id-"
                $index = substr($key, strlen('car_model_id-'));
                $carModels[$index] = $value;
            }
        }
        // dd($carModels);

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
                $sparepartDetails[] = [
                    'sparepart_id' => $sparepart->id,
                    'car_brand_id' => $carBrand,
                    'car_model_id' => $carModels[$index],
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
                $modificationDetails[] = [
                    'modification_id' => $modification->id,
                    'car_brand_id' => $carBrand,
                    'car_model_id' => $carModels[$index],
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
        // dd($type, $id);

        $car_brand = Car_brand::all();

        if($type == 'sparepart'){
            $products = Spareparts::select(
                'spareparts.id as product_id',
                'product_name as product_name',
                'sparepart_name as name',
                'sparepart_image as image',
                'sparepart_price as price',
                'sparepart_height as height',
                'sparepart_weight as weight',
                DB::raw("'sparepart' as type")
            )
            ->join('products', 'spareparts.product_id', '=', 'products.id')
            ->where('spareparts.id', $id)
            ->where('store_id', $storeId)->first();
        }else{
            $products = Modification::select(
                'modifications.id as product_id',
                'product_name as product_name',
                'mod_image as image',
                'mod_name as name',
                'mod_price as price',
                'mod_height as height',
                'mod_weight as weight',
                DB::raw("'modification' as type")
            )
            ->join('products', 'modifications.product_id', '=', 'products.id')
            ->where('modifications.id', $id)
            ->where('store_id', $storeId)->first();
        }
        // dd($products);

        return view('store.editProduct', [
            'title' => 'Edit Product',
            'products' => $products,
            'car_brand' => $car_brand
        ]);
    }

    public function updateProductForm(){

        // if($request->file('filename') == null){
        //     $store->save();
        //     return redirect()->back()->with('success', 'Store profile has been updated successfully.');
        // }

        // $oldImage = $store->store_logo;
        // $imageName = !empty($request->file('img_product')) ? $request->file('img_product')->getClientOriginalName() : $oldImage;
        // $newImage = $imageName;

        // if (!empty($request->file('img_product'))) {
        //     $newImage = uniqid() . '_' . $imageName;
        //     $request->file('img_product')->move(storage_path('app/imageProfile'), $newImage);
        // }

        // $store->store_logo = $newImage;
        // $store->save();

        // if ($oldImage && $oldImage !== $newImage && !empty($request->file('img_product'))) {
        //     unlink(storage_path('app/imageProfile/' . $oldImage));
        // }

        // return redirect()->back()->with('successAdd', 'Product has been added successfully.');
    }

    public function getCarBrand(Request $request){
        $car_model = Car_model::where('car_brand_id', $request->id)->get();

        return $car_model;
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
