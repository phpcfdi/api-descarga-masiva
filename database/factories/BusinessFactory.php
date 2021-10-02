<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rfc' => $this->faker->unique()->{'mexicanRfc'}(),
            'legal_name' => $this->faker->company(),
            'common_name' => $this->faker->word(),
            'certificate' => base64_encode(Str::random(1024)),
            'private_key' => base64_encode(Str::random(1024)),
            'passphrase' => Str::random(10),
            'valid_until' => $this->faker->dateTimeInInterval('-6 months', '+1 year'),
        ];
    }
}
