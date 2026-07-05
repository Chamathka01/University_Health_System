<?php

namespace Database\Seeders;

use App\Models\Register;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Register::updateOrCreate([
            'email' => 'chamathkahettiarachchi@gmail.com',
        ], [
            'role' => 'nurse',
        ]);
    }
}
