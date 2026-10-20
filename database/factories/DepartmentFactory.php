<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departmentCode = [
            'MKT',
            'OPS',
            'PROC',
            'LEGAL',
            'LOG',
            'RND',
            'HSE',
            'PR',
            'CSR',
            'GA',
        ];

        return [
            'code' => fake()->unique()->randomElement($departmentCode),
            'name' => fake()->name(),
        ];
    }
}
