<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AccomodationLocationSeeder extends Seeder
{
    public function run()
    {
        DB::table('accomodationlocations')->insert([
            [
                'locationid' => Str::uuid(),
                'city' => 'Beirut',
                'address' => 'Downtown Beirut, near Zaitunay Bay',
                'latitude' => 33.8938,
                'longitude' => 35.5018,
               
            ],
            [
                'locationid' => Str::uuid(),
                'city' => 'Jounieh',
                'address' => 'Kaslik, seaside road',
                'latitude' => 33.9808,
                'longitude' => 35.6151,
                
            ],
            [
                'locationid' => Str::uuid(),
                'city' => 'Byblos',
                'address' => 'Byblos Old Souks, near the harbor',
                'latitude' => 34.1203,
                'longitude' => 35.6485,
                
            ],
            [
                'locationid' => Str::uuid(),
                'city' => 'Tripoli',
                'address' => 'El Mina, near the Corniche',
                'latitude' => 34.4331,
                'longitude' => 35.8442,
                
            ],
            [
                'locationid' => Str::uuid(),
                'city' => 'Baalbek',
                'address' => 'Near Baalbek Temple ruins',
                'latitude' => 34.0058,
                'longitude' => 36.2110,
                
            ],
            [
                'locationid' => Str::uuid(),
                'city' => 'Zahle',
                'address' => 'Main road, near Berdawni River',
                'latitude' => 33.8500,
                'longitude' => 35.9042,
               
            ],
            [
                'locationid' => Str::uuid(),
                'city' => 'Sidon',
                'address' => 'Old Sidon, near Sea Castle',
                'latitude' => 33.5631,
                'longitude' => 35.3683,
               
            ],
            [
                'locationid' => Str::uuid(),
                'city' => 'Tyre',
                'address' => 'Tyre Old City, near Al-Bass ruins',
                'latitude' => 33.2707,
                'longitude' => 35.2038,
                
            ],
            [
                'locationid' => Str::uuid(),
                'city' => 'Batroun',
                'address' => 'Batroun Old City, near Phoenician wall',
                'latitude' => 34.2558,
                'longitude' => 35.6582,
                
            ],
            [
                'locationid' => Str::uuid(),
                'city' => 'Bsharri',
                'address' => 'Cedars of God Forest',
                'latitude' => 34.2514,
                'longitude' => 36.0104,
               
            ],
        ]);
    }
}
