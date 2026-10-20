<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    use HasFactory;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::factory()->count(10)->create();
    }
}
