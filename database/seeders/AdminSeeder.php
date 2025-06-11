<?php

namespace Database\Seeders;

use App\Models\dashboard\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        $admin->create([
            'name'=>'Mohamed',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('11111111'),
            'account_type'=>'admin',
            'status'=>'1',
        ]);
    }
}
