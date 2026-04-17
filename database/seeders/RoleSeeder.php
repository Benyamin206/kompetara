<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // jangan lupa import model

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['nama_role' => 'admin'],
            ['nama_role' => 'pemilik_course'],
            ['nama_role' => 'customer'],
        ]);
    }
}