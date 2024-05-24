<?php

namespace App\Http\Controllers;

use App\Models\Car_brand;
use App\Models\Car_model;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(){

        $year = Car_model::select('car_year')->distinct()->orderBy('car_year', 'asc')->get();

        return view('home', [
            'nama' => 'Welcome, user!',
            'image' => 'Logo SpareCar.png',
            'title' => 'Home',
            'year' => $year,
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
        Log::info($request->car_year);
        $carModel = Car_model::where('car_brand_id', $request->brand_id)
        ->where('car_year', $request->car_year)
        ->select('car_model_name', 'id')
        ->distinct()
        ->get();

        return $carModel;
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
