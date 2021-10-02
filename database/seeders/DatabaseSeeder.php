<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

        $this->call(UserSeeder::class);
        $this->call(BusinessSeeder::class);
        $this->call(PetitionSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(PetitionLogSeeder::class);
    }
}
