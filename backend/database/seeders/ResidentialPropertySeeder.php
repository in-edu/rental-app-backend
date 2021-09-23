<?php

namespace Database\Seeders;

use App\Models\ResidentialProperty;
use Illuminate\Database\Seeder;

class ResidentialPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResidentialProperty::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            ResidentialProperty::create([
                'street' => $faker->streetAddress,
                'city' => $faker->city,
                'square_footage' => $faker->numberBetween(10, 1000),
                'price' => $faker->numberBetween(10, 10000),
                'rooms_number' => $faker->randomDigit,
                'parking_spaces' => $faker->randomDigit,
                'category' => $faker->randomElement(['Sell', 'Rent']),
                // 'info' => $faker->randomElement([`Enjoying a central location in Belgrade, Queen's Apartments is only 250 m from the pedestrian zone Knez Mihajlova and the Strahinjica Bana filled with restaurants and bars. It offers air-conditioned accommodations with free Wi-Fi.`, `Offering air-conditioned accommodations, Ben Akiba Luxury Suites is located in the center of Belgrade, 100 m from Trg Republike Belgrade. Free WiFi is offered throughout the property.`, `Located 3.7 mi from Ada Ciganlija, White Apartments features accommodations with free WiFi and free private parking.`, `Apartments Royal - Belgrade Waterfront is located in the Savski Venac district of Belgrade, 1.1 mi from Republic Square Belgrade and 1.5 mi from Splavovi. Complimentary WiFi is available throughout the property and private parking is available on site.`]),
                'info' => $faker->text(),
                // 'image' => $faker->randomElement([`https://cf.bstatic.com/images/hotel/max1024x768/180/180503648.jpg`, `https://cf.bstatic.com/images/hotel/max1024x768/120/120439456.jpg`, `https://cf.bstatic.com/images/hotel/max1024x768/263/263774710.jpg`, `https://cf.bstatic.com/images/hotel/max1024x768/248/248313934.jpg`]),
                'user_id' => \App\Models\User::all()->random()->id,
                // 'name' => $faker->randomElement(['The Glass House.', `Artist's Alley.`, `Town Place Walkups.`, `The Corner of Main`, `East Side Living.`, `Sunrise Apartments.`]),
                'name' => $faker->name(),
            ]);
        }
    }
}
