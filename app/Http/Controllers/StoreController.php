<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index(){
        return view('store.allProductList', [
            'title' => 'Product List',
        ]);
    }

    public function editProfileStore(Request $request)
    {
        $userId = Session::get('user_id');
        $user = User::find($userId);

        $storeId = $request->input('store_id');
        $store = Store::find($storeId);

        // Inisialisasi array untuk menyimpan aturan validasi
        $rules = [];

        // Cek perubahan pada form
        $storeNameChanged = empty($request->input('name')) || $request->input('name') !== $user->name;
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
                'name' => 'required|unique:users|min:5|max:255',
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
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        // Update tabel stores
        $store->update([
            'store_name' => $request->input('name'),
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

    public function loadModificationList (){
        return view('store.modificationList', [
            'title' => 'Modification',
        ]);
    }

    public function loadSparePartList (){
        return view('store.sparePartList', [
            'title' => 'Spare Part',
        ]);
    }
}
