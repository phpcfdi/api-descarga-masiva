<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Petition;
use App\Models\PetitionLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetitionLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PetitionLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'occurred_at' => $this->faker->dateTime(),
            'message' => $this->faker->sentence(),
            'request' => $this->faker->text(),
            'response' => $this->faker->text(),
            'petition_id' => Petition::factory(),
        ];
    }
}
