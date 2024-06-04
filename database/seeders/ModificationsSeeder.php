<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modification;
use App\Models\ModificationDetail;

class ModificationsSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 25; $i++) {
            // Modification::create([
            //     'product_id' => 5,
            //     'store_id' => rand(1, 3),
            //     'mod_name' => "AIRSUS | AIRBFT SUSPENSION | GOLD FULL KIT PACKAGE - SHOCK ABSORBER " . $i,
            //     'mod_image' => 'Airbft Suspension.jpg',
            //     'mod_price' => '268000' . $i,
            //     'mod_weight' => '10' . $i,
            //     'mod_height' => '10' . $i,
            //     'description' => '
            //         GOLD FULL KIT PACKAGE (DOUBLE COMPRESSOR) consists of:
            //         1. CONTROLLER (INTEGRATED ECU VALVE)
            //         2. BLUETOOTH MODULE (APP)
            //         3. TOUCHPAD CONTROLLER (ALLUMINIUM ALLOY)
            //         4. DOUBLE COMPRESSOR (QUIET TYPE)
            //         5. 120 AMP POWER SUPPLY KIT
            //         6. AIR TANK (ALLUMINIUM ALLOY)
            //         7. WATER SEPARATOR (ALLUMINIUM ALLOY)
            //         8. G 1/4 WHOLE VEHICLE PIPELINE
            //         9. AIR SHOCK ABSORBER (x4)
            //         10. PROTECTIVE SLEEVE FRONT WHEEL PIPELINE (x2)
            //         11. SHOCK ABSORBER DAMPING ADJUST THE TOOL (x2)
            //         12. SHOCK ABSORBER HEIGHT ADJUST THE TOOL (x2)
            //         13. PIPELINE SCISSORS
            //         14. THREAD GLUE',
            //     'link_tokopedia' => 'https://www.tokopedia.com/airbftsuspension/airsus-airbft-suspension-gold-full-kit-package-shock-absorber',
            //     'link_shopee' => 'https://shopee.co.id/AIRBFT-SUSPENSION-GOLD-FULL-KIT-PACKAGE-(DOUBLE-COMPRESSOR)-i.931200858.23015887607?xptdk=6b18ad51-9722-44f7-bb54-1ff57b73975b',
            //     'notes' => 'Additional notes for modification ' . $i,
            // ]);
        }
    }
}
