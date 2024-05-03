<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        Log::info("Masuk ke dalam metode index pada AdminController");
        $store = Store::whereNull('store_code')
            ->join('users', 'stores.user_id', '=', 'users.id')
            ->orderBy('stores.created_at', 'desc')
            ->select('stores.*', 'users.email')
            ->simplePaginate(3);

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
        return view('admin.Car_brand_list', [
            'title' => 'CAR BRAND LIST',
        ]);
    }

    public function carPartList(){
        Log::info("Masuk ke dalam metode carPartList pada AdminController");
        return view('admin.Car_part_list', [
            'title' => 'CAR PART LIST',
        ]);
    }
}
