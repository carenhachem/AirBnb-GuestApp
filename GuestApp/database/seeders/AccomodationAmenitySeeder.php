<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccomodationAmenitySeeder extends Seeder
{
    public function run()
    {
        $accomodations = [
            '33c23200-3204-491f-8d44-59a6b5536871', // Luxury Suite in Beirut
            'dfe5e1e2-ab28-454a-bfe8-ba4d89362206', // Seaside Villa in Jounieh
            '00554a08-8bb8-48e2-8a62-e9d948ddb3f6', // Cozy Apartment in Byblos
            '551216fa-440a-4207-b9e1-a11e9fb361cd', // Heritage Chalet in Baalbek
            'faff8f4b-71de-4489-b431-5603bdd73985', // Beachfront Cabin in Tyre
            '3d260726-d1aa-4598-90df-485e3e5ce13a', // Phoenician View in Batroun
            'ac950e0b-d528-4573-a8b8-752db9cac87f', // Cedar Chalet in Bsharri
        ];

        $amenities = [
            '902ca7d0-7b2e-49ab-8ff5-b6e53b8cb9c4', // Wi-Fi
            '9b81e220-cb83-4c31-b928-7be54bcdb051', // Air Conditioning
            '6eaebc1e-58c8-4030-a2f3-cfcf99a08a76', // Swimming Pool
            'dda95717-5768-499a-b379-1e07d5809e39', // Free Parking
            '354ae440-b97c-4576-b63a-c3839b1d9028', // Gym/Fitness Center
            '9dce7eea-1bd3-4fb7-9840-607db0da9e45', // Pets Allowed
            '5c38bffe-bb8f-4677-a772-925716f8b9dd', // 24/7 Concierge Service
        ];

        $accomodationAmenities = [];

        foreach ($accomodations as $accomodationId) {
            
            $randomAmenities = array_rand(array_flip($amenities), rand(2, 5));

            foreach ($randomAmenities as $amenityId) {
                $accomodationAmenities[] = [
                    'accomodationamenityid' => Str::uuid(),
                    'accomodationid' => $accomodationId,
                    'amenityid' => $amenityId,
                    
                ];
            }
        }

        // Insert the generated data into the database
        DB::table('accomodationamenities')->insert($accomodationAmenities);
    }
}