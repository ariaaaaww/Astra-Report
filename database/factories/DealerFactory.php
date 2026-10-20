<?php

namespace Database\Factories;

use App\Models\Dealer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dealer>
 */
class DealerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dealerCode = [
            'DLR-001',
            'DLR-002',
            'DLR-003',
            'DLR-004',
            'DLR-005',
            'DLR-006',
            'DLR-007',
            'DLR-008',
            'DLR-009',
            'DLR-010',
        ];

        return [
            'code' => fake()->unique()->randomElement($dealerCode),
            'name' => fake()->name(),
        ];

    }
}
