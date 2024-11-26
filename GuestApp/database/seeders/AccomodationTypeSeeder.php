<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AccomodationTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('accomodationtypes')->insert([
            [
                'typeid' => Str::uuid(),
                'accomodationdesc' => 'Apartment',
                'isactive' => true,
                
            ],
            [
                'typeid' => Str::uuid(),
                'accomodationdesc' => 'Villa',
                'isactive' => true,
                
            ],
            [
                'typeid' => Str::uuid(),
                'accomodationdesc' => 'Chalet',
                'isactive' => true,
                
            ],
            [
                'typeid' => Str::uuid(),
                'accomodationdesc' => 'Cabin',
                'isactive' => true,
                
            ],
        ]);
    }
}

