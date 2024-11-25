<?php

namespace Database\Factories;

use App\Models\accomodation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservationid' => Str::uuid(),  // Generate a random UUID for reservationid
            'userid' => Str::uuid(),     // Create a random user ID using the User factory
            'accomodationid' => Str::uuid(),  // Create a random accommodation ID using the Accomodation factory
            'checkin' => $this->faker->date(),  // Random check-in date
            'checkout' => $this->faker->date(), // Random checkout date
            'totalprice' => $this->faker->randomFloat(2, 50, 500),  // Random total price between 50 and 500
            'isreserved' => true,  // 80% chance of being reserved
            'created' => now(),  // Created timestamp
            'updated' => now(),  // Updated timestamp        
            ];
    }
}
