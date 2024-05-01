<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function formRegisterUser(){
        return view('register');
    }

    public function postRegisterUser(Request $request){
        $validateData = $request->validate([
            'name' => 'required|unique:users|min:5|max:255',
            'username' => 'required|unique:users|min:5|max:255',
            'email' => 'required|unique:users|email:dns',
            'password' => 'required|min:8|max:255'
        ]);

        $validateData['role'] = 'user';
        $validateData['password'] = Hash::make($validateData['password']);

        User::create($validateData);

        return redirect('/login')->with('success', 'Registration successfull! Please login');
    }

    public function formRegisterStore(){
        $provinces = DB::table('province')->get();

        return view('registerStore', compact('provinces'));
    }

    public function postRegisterStore(Request $request){
        $validatedData = $request->validate([
            // Validasi untuk tabel users
            'name' => 'required|unique:users|min:5|max:255',
            'username' => 'required|unique:users|min:5|max:255',
            'email' => 'required|unique:users|email:dns',
            'password' => 'required|min:8|max:255',

            // Validasi untuk tabel stores
            'store_phone' => 'required|unique:stores|regex:/^\d{10,}$/',
            'store_address' => 'required',
            'store_instagram' => 'required',
            'store_tokopedia' => 'required|url',
            'store_shopee' => 'required|url',
            'store_province' => 'required',
            'store_city' => 'required',
            'store_district' => 'required',
            'store_subdistrict' => 'required',
            'store_postal_code' => 'required',
        ]);

        $validatedData['role'] = 'store';
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        $validatedStoreData = $validatedData;
        $validatedStoreData['user_id'] = $user->id;
        $validatedStoreData['store_name'] = $user->name;
        Store::create($validatedStoreData);

        return response()->json([
            'success' => true
        ]);
    }

    public function getCity(Request $request)
    {
        $cities = DB::table('city')->where('province_id', $request->id)->get();

        return $cities;
    }

    public function getDistrict(Request $request){
        $districts = DB::table('district')->where('city_id', $request->id)->get();

        return $districts;
    }

    public function getSubdistrict(Request $request){
        $subdistricts = DB::table('subdistrict')->where('district_id', $request->id)->get();

        return $subdistricts;
    }
}
