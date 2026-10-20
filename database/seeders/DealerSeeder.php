<?php

namespace Database\Seeders;

use App\Models\Dealer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;

class DealerSeeder extends Seeder
{
    use HasFactory;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dealer::factory()->count(10)->create();
    }
}
