<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin LensRent',
            'email' => 'admin@lensrent.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $jumlahCustomer = (int) env('SEEDER_CUSTOMER_COUNT', 50);

        $faker = Faker::create('id_ID');
        for ($i = 0; $i < $jumlahCustomer; $i++) {
            User::firstOrCreate(
                ['email' => $faker->unique()->safeEmail],
                [
                    'name' => $faker->name,
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                ]
            );
        }

        $this->command->info("UserSeeder selesai: 1 admin dan {$jumlahCustomer} customer.");
    }
}
