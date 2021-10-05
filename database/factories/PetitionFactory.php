<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Business;
use App\Models\Petition;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Petition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'download_service' => $this->faker->randomElement(['cfdi', 'retentions']),
            'download_type' => $this->faker->randomElement(['cfdi', 'metadata']),
            'download_nature' => $this->faker->randomElement(['issued', 'received']),
            'period_since' => $since = $this->faker->dateTimeBetween('-12 months', '-3 months'),
            'period_until' => $this->faker->dateTimeBetween($since),
            'status' => 'created',
            'sat_request' => $this->faker->uuid(),
            'business_id' => Business::factory(),
        ];
    }
}
