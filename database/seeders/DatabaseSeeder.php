<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        User::factory()
            ->count(1)
            ->admin()
            ->create([
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
            ]);

        $this->call(UserSeeder::class);
        $this->call(BusinessSeeder::class);
        $this->call(PetitionSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(PetitionLogSeeder::class);
    }
}
