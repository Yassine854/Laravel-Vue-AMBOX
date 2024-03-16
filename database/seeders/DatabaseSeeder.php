<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'phone'=>'22222222',
            'email' => 'admin@test.com',
            'role' => 1,
            'password' => Hash::make('admin@test.com'),
        ]);

        DB::table('last_voyage_id')->insert([
            'last_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
