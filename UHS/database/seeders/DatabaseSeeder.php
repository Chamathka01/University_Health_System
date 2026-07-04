<?php

namespace Database\Seeders;

use App\Models\Register;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'role' => 'admin',
            'password' => Hash::make(Str::random(32)),
            'regno' => null,
            'staff_id' => null,
        ]);
    }
}
