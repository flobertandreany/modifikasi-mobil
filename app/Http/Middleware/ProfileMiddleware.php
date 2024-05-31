<?php

namespace App\Http\Middleware;

use App\Models\City;
use App\Models\District;
use App\Models\Product;
use App\Models\Province;
use App\Models\Store;
use App\Models\Subdistrict;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $menuSparepart = Product::select('products.*', DB::raw("'sparepart' as type"))->where('product_category_id', 1)->get();
        $menuModification = Product::select('products.*', DB::raw("'modification' as type"))->where('product_category_id', 2)->get();

        if (Auth::check()) {
            $profileUserAdmin = $this->getProfileUserAdmin();

            view()->share([
                'user' => $profileUserAdmin,
                'spareparts' => $menuSparepart,
                'modifications' => $menuModification,
            ]);

            if (Auth::user()->role == 'store') {
                $profileStore = $this->getProfileStore();

                view()->share([
                    'store' => $profileStore['store'],
                    'provinces' => $profileStore['provinces'],
                    'cities' => $profileStore['cities'],
                    'districts' => $profileStore['districts'],
                    'subdistricts' => $profileStore['subdistricts'],
                ]);
            }
        } else {
            view()->share([
                'spareparts' => $menuSparepart,
                'modifications' => $menuModification,
            ]);
        }

        return $next($request);
    }

    public function getProfileUserAdmin(){
        $userId = Session::get('user_id');

        $data = User::select('users.*')
        ->where('id', $userId)
        ->first();

        return $data;
    }

    public function getProfileStore(){
        $userId = Session::get('user_id');

        $data['store'] = Store::select('stores.*', 'stores.id as store_id', 'users.email as store_email')
        ->join('users', 'stores.user_id', '=', 'users.id')
        ->join('province','stores.store_province','=','province.id')
        ->join('city','stores.store_city','=','city.id')
        ->join('district','stores.store_district','=','district.id')
        ->join('subdistrict','stores.store_subdistrict','=','subdistrict.id')
        ->where('user_id', $userId)
        ->first();

        $store = $data['store'];

        $data['provinces'] = Province::all();
        $data['cities'] = City::where('province_id', $store->store_province)->get();
        $data['districts'] = District::where('city_id', $store->store_city)->get();
        $data['subdistricts'] = Subdistrict::where('district_id', $store->store_district)->get();

        return $data;
    }
}
