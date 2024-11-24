<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AccomodationSeeder extends Seeder
{
    public function run()
    {
        DB::table('accomodations')->insert([
            [
                'accomodationid' => Str::uuid(),
                'description' => 'Luxury Suite in Beirut',
                'pricepernight' => 200,
                'typeid' => '9cc90418-a834-48c2-b0bd-b83d0ef2f98c', // Apartment
                'locationid' => 'c4acf50a-cf34-4152-a7dc-209be221ddc3', // Beirut
                'guestcapacity' => 2,
                'rating' => 4.5,
                'image' => json_encode(['url' => 'beirut_suite.jpg']),
                'isactive' => true,
                
            ],
            [
                'accomodationid' => Str::uuid(),
                'description' => 'Seaside Villa in Jounieh',
                'pricepernight' => 300,
                'typeid' => 'b463199b-6851-4546-bd69-79a1c5613630', // Villa
                'locationid' => '35a5b5f9-9aac-4591-9d21-77f529582886', // Jounieh
                'guestcapacity' => 4,
                'rating' => 4.8,
                'image' => json_encode(['url' => 'jounieh_villa.jpg']),
                'isactive' => true,
                
            ],
            [
                'accomodationid' => Str::uuid(),
                'description' => 'Cozy Apartment in Byblos',
                'pricepernight' => 100,
                'typeid' => '9cc90418-a834-48c2-b0bd-b83d0ef2f98c', // Apartment
                'locationid' => 'ff003d06-ec63-4778-8aa3-528c834cc2b8', // Byblos
                'guestcapacity' => 3,
                'rating' => 4.0,
                'image' => json_encode(['url' => 'byblos_apartment.jpg']),
                'isactive' => true,
                
            ],
            [
                'accomodationid' => Str::uuid(),
                'description' => 'Heritage Chalet in Baalbek',
                'pricepernight' => 250,
                'typeid' => '769e43d0-afee-413f-9aea-7d6b85a75230', // Chalet
                'locationid' => '6fa2c291-52fd-4c6c-a11d-e5f6dc3010c3', // Baalbek
                'guestcapacity' => 5,
                'rating' => 4.7,
                'image' => json_encode(['url' => 'baalbek_chalet.jpg']),
                'isactive' => true,
                
            ],
            [
                'accomodationid' => Str::uuid(),
                'description' => 'Beachfront Cabin in Tyre',
                'pricepernight' => 140,
                'typeid' => 'e3dbd454-884a-410a-b548-437c5a4d7715', // Cabin
                'locationid' => 'e5620433-dd65-4a2d-a03c-9f347ac076b4', // Tyre
                'guestcapacity' => 2,
                'rating' => 4.3,
                'image' => json_encode(['url' => 'tyre_cabin.jpg']),
                'isactive' => true,
                
            ],
            [
                'accomodationid' => Str::uuid(),
                'description' => 'Phoenician View in Batroun',
                'pricepernight' => 170,
                'typeid' => 'b463199b-6851-4546-bd69-79a1c5613630', // Villa
                'locationid' => '6991354b-e165-4ac3-8dde-0ec0d8045a13', // Batroun
                'guestcapacity' => 3,
                'rating' => 4.6,
                'image' => json_encode(['url' => 'batroun_view.jpg']),
                'isactive' => true,
                
            ],
            [
                'accomodationid' => Str::uuid(),
                'description' => 'Cedar Chalet in Bsharri',
                'pricepernight' => 220,
                'typeid' => '769e43d0-afee-413f-9aea-7d6b85a75230', // Chalet
                'locationid' => '72dd97ea-2a1c-468c-9633-82a21872c83a', // Bsharri
                'guestcapacity' => 5,
                'rating' => 4.9,
                'image' => json_encode(['url' => 'bsharri_chalet.jpg']),
                'isactive' => true,
                
            ],
        ]);
    }
}

