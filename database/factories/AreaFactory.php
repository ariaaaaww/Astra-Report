<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Area>
 */
class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $areaCode = [
            'KALBAR-1',
            'KALBAR-2',
            'KALBAR-3',
            'KALBAR-4',
            'KALTIM-1',
            'KALTIM-2',
            'KALTENG-1',
            'KALSEL-1',
            'DKI-1',
            'JABAR-1',
        ];

        return [
            'code' => fake()->unique()->randomElement($areaCode),
            'name' => fake()->name(),
        ];
    }
}
