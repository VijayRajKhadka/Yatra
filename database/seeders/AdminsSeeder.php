<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
            $admin  = new Admins;
            $admin->name = 'Vijay Raj Khadka';
            $admin->email = 'superadmin@gmail.com';
            $admin->role='1';
            $admin->password = Hash::make('admin');
            $admin->email_verified_at = now();
            $admin->save();

        
    }
}
