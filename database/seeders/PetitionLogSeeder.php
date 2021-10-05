<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PetitionLog;
use Illuminate\Database\Seeder;

class PetitionLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PetitionLog::factory()
            ->count(5)
            ->create();
    }
}
