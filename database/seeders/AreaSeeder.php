<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    use HasFactory;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::factory()->count(10)->create();
    }
}
