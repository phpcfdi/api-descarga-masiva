<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Package;
use App\Models\Petition;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Package::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sat_package' => $this->faker->uuid(),
            'status' => 'pending',
            'path' => $this->faker->text(),
            'petition_id' => Petition::factory(),
        ];
    }
}
