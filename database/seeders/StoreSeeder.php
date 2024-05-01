<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     DB::table('stores')->insert([
    //         [
    //             'store_name' => 'Toko jeta',
    //             'user_id' => 3, // Ganti dengan user_id yang sesuai
    //             'store_address' => 'Alamat Toko A',
    //             'store_phone' => '08123456789',
    //             'store_instagram' => 'tokoa_instagram',
    //             'store_tokopedia' => 'tokoa_tokopedia',
    //             'store_shopee' => 'tokoa_shopee',
    //             'store_province' => 'Provinsi A', // Ganti 'store_city' dengan 'store_province
    //             'store_city' => 'Kota A',
    //             'store_district' => 'Kecamatan A',
    //             'store_village' => 'Desa A',
    //             'store_postal_code' => '12345',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //         [
    //             'store_name' => 'Toko bobo',
    //             'user_id' => 5, // Ganti dengan user_id yang sesuai
    //             'store_address' => 'Alamat Toko B',
    //             'store_phone' => '08234567890',
    //             'store_instagram' => 'tokob_instagram',
    //             'store_tokopedia' => 'tokob_tokopedia',
    //             'store_shopee' => 'tokob_shopee',
    //             'store_province' => 'Provinsi B', // Ganti 'store_city' dengan 'store_province
    //             'store_city' => 'Kota B',
    //             'store_district' => 'Kecamatan B',
    //             'store_village' => 'Desa B',
    //             'store_postal_code' => '23456',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //         // Tambahkan data toko lainnya sesuai kebutuhan
    //     ]);
    // }

    public function run()
    {
        // Buat 5 data toko
        for ($i = 5; $i < 8; $i++) {
            Store::create([
                'store_name' => 'Toko ' . ($i + 1),
                'store_code' => 'STORE00' . ($i + 1),
                'user_id' => ($i + 1), // ID pengguna yang terkait dengan toko
                'store_address' => 'Alamat Toko ' . ($i + 1),
                'store_phone' => '08123456789',
                'store_instagram' => 'instagram_toko_' . ($i + 1),
                'store_tokopedia' => 'tokopedia.com/toko' . ($i + 1),
                'store_shopee' => 'shopee.co.id/toko' . ($i + 1),
                'store_province' => 'Provinsi B' . ($i + 1),
                'store_city' => 'Kota ' . ($i + 1),
                'store_district' => 'Kecamatan ' . ($i + 1),
                'store_subdistrict' => 'Desa ' . ($i + 1),
                'store_postal_code' => '12345',
            ]);
        }
    }
}
