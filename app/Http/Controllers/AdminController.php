<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        Log::info("Masuk ke dalam metode index pada AdminController");
        $store = Store::whereNull('store_code')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(3);

        return view('admin.Store_approval_list', [
            'title' => 'STORE APPROVAL LIST',
            'store' => $store,
        ]);
    }

    public function approvalStore($id){
        Log::info("Masuk ke dalam metode approvalStore pada AdminController");
        if(isset($_POST['approve'])){
            $store = Store::find($id);

            if ($store) {
                $store->store_code = 'STR_' . $store->id . '_' . date('dmy');
                $store->save();
            }
        }else if(isset($_POST['reject'])){
            $store = Store::find($id);

            if ($store) {
                $store->delete();
            }
        }

        return redirect()->route('admin.store.approval');
    }

    // public function getStoreDetail($id){
    //     Log::info('Ini adalah pesan info');
    //     echo "Masuk ke sini";
    //     $store = Store::find($id);

    //     if ($store) {
    //         return response()->json($store);
    //     }

    //     return view('admin.Store_approval_detail', [
    //         'title' => 'STORE APPROVAL DETAIL',
    //         'store' => $store,
    //     ]);
    // }
}
