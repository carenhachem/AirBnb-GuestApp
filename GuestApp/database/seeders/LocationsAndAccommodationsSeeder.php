<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationsAndAccommodationsSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            ['city' => 'Zahle', 'latitude' => 33.8500, 'longitude' => 35.9042],
            ['city' => 'Jezzine', 'latitude' => 33.5421, 'longitude' => 35.5842],
            ['city' => 'Aley', 'latitude' => 33.8057, 'longitude' => 35.5906],
            ['city' => 'Kfardebian', 'latitude' => 33.9975, 'longitude' => 35.8284],
            ['city' => 'Bekaa', 'latitude' => 34.0106, 'longitude' => 36.2028],
            ['city' => 'Ehden', 'latitude' => 34.2903, 'longitude' => 35.9764],
            ['city' => 'Deir el Qamar', 'latitude' => 33.6975, 'longitude' => 35.5652],
            ['city' => 'Hasroun', 'latitude' => 34.2901, 'longitude' => 35.9502],
            ['city' => 'Chekka', 'latitude' => 34.3391, 'longitude' => 35.7272],
            ['city' => 'Broumana', 'latitude' => 33.8848, 'longitude' => 35.6206],
            ['city' => 'Rashaya', 'latitude' => 33.5135, 'longitude' => 35.8478],
            ['city' => 'Anfeh', 'latitude' => 34.3417, 'longitude' => 35.7321],
            ['city' => 'Qobayat', 'latitude' => 34.5656, 'longitude' => 36.0987],
            ['city' => 'Hermel', 'latitude' => 34.3917, 'longitude' => 36.3861],
            ['city' => 'Barouk', 'latitude' => 33.6898, 'longitude' => 35.6719],
            ['city' => 'Maaser el Shouf', 'latitude' => 33.6925, 'longitude' => 35.6936],
            ['city' => 'Chouf', 'latitude' => 33.6836, 'longitude' => 35.6611],
            ['city' => 'Damour', 'latitude' => 33.7428, 'longitude' => 35.4856],
            ['city' => 'Feytroun', 'latitude' => 33.9811, 'longitude' => 35.7596],
            ['city' => 'Jeita', 'latitude' => 33.9469, 'longitude' => 35.6485],
            ['city' => 'Tripoli', 'latitude' => 34.4361, 'longitude' => 35.8456],
            ['city' => 'Baalbek', 'latitude' => 34.0012, 'longitude' => 36.2118],
            ['city' => 'Tyre', 'latitude' => 33.2722, 'longitude' => 35.2035],
            ['city' => 'Sidon', 'latitude' => 33.5639, 'longitude' => 35.3691],
            ['city' => 'Batroun', 'latitude' => 34.2565, 'longitude' => 35.6578],
            ['city' => 'Bsharri', 'latitude' => 34.2519, 'longitude' => 36.0112],
            ['city' => 'Zouk Mosbeh', 'latitude' => 33.9788, 'longitude' => 35.6246],
            ['city' => 'Saifi', 'latitude' => 33.8994, 'longitude' => 35.5113],
            ['city' => 'Jbeil', 'latitude' => 34.1245, 'longitude' => 35.6462],
            ['city' => 'Naqoura', 'latitude' => 33.1223, 'longitude' => 35.1518],
            ['city' => 'Riyaq', 'latitude' => 33.8501, 'longitude' => 36.0000],
            ['city' => 'Faraya', 'latitude' => 33.9978, 'longitude' => 35.8445],
            ['city' => 'Douma', 'latitude' => 34.1600, 'longitude' => 35.8589],
            ['city' => 'Jouret El Ballout', 'latitude' => 33.8971, 'longitude' => 35.6490],
            ['city' => 'Ajaltoun', 'latitude' => 33.9771, 'longitude' => 35.6738],
            ['city' => 'Ain Saadeh', 'latitude' => 33.8989, 'longitude' => 35.6055],
            ['city' => 'Baakline', 'latitude' => 33.6943, 'longitude' => 35.5917],
            ['city' => 'Kobayat', 'latitude' => 34.5660, 'longitude' => 36.0994],
            ['city' => 'Tannourine', 'latitude' => 34.2394, 'longitude' => 35.9069],
            ['city' => 'Marjeyoun', 'latitude' => 33.3572, 'longitude' => 35.5924],
        ];

        // Insert locations
        $locationIds = [];
        foreach ($locations as $location) {
            $id = Str::uuid();
            $locationIds[] = $id;
            DB::table('accomodationlocations')->insert([
                'locationid' => $id,
                'city' => $location['city'],
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
                'address' => $location['city'] . ' Center',
               
            ]);
        }

        // Insert accommodations
        $accommodations = [];
        foreach ($locationIds as $index => $locationId) {
            $accommodations[] = [
                'accomodationid' => Str::uuid(),
                'description' => 'Accommodation ' . ($index + 1),
                'pricepernight' => rand(50, 500),
                'typeid' => $locationId, // Assuming 'typeid' relates to location for now
                'locationid' => $locationId,
                'guestcapacity' => rand(1, 6),
                'rating' => round(rand(35, 50) / 10, 1), // Random rating between 3.5 and 5.0
                'image' => json_encode(['url' => 'accommodation_' . ($index + 1) . '.jpg']),
                'isactive' => true,
                
            ];
        }

        DB::table('accomodations')->insert($accommodations);
    }
}
