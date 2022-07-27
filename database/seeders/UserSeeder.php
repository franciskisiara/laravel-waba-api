<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private function seedSudoers () 
    {
        User::firstOrCreate([
            'phone' => '254711887341',
        ], [
            'name' => 'Frank Rascan',
            'phone' => '254711887341',
            'phone_verified_at' => now(),
        ]);
    } 

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedSudoers();
        
        for ($index = 0; $index < 5000; $index++)
        {
            $verified = fake()->boolean();
            $phone = "254" . fake()->numerify('#########');

            User::firstOrCreate([
                'phone' => $phone,
            ], [
                'name' => fake()->name(),
                'phone' => $phone,
                'phone_verified_at' => $verified ? fake()->dateTime() : null,
            ]);
        }
    }
}
