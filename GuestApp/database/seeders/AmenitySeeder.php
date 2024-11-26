<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class AmenitySeeder extends Seeder
{
    public function run()
    {
        DB::table('amenities')->insert([
            [
                'amenityid' => Str::uuid(),
                'amenitydesc' => 'Wi-Fi',
                'isactive' => true,
             
            ],
            [
                'amenityid' => Str::uuid(),
                'amenitydesc' => 'Air Conditioning',
                'isactive' => true,
          
            ],
            [
                'amenityid' => Str::uuid(),
                'amenitydesc' => 'Swimming Pool',
                'isactive' => true,
               
            ],
            [
                'amenityid' => Str::uuid(),
                'amenitydesc' => 'Free Parking',
                'isactive' => true,
              
            ],
            [
                'amenityid' => Str::uuid(),
                'amenitydesc' => 'Gym/Fitness Center',
                'isactive' => true,
          
            ],
            [
                'amenityid' => Str::uuid(),
                'amenitydesc' => 'Pets Allowed',
                'isactive' => true,
               
            ],
            [
                'amenityid' => Str::uuid(),
                'amenitydesc' => '24/7 Concierge Service',
                'isactive' => true,
               
            ],

        ]);
    }
}

