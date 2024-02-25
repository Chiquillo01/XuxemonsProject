<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Date;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 0,
            'nick' => 'admin',
            'email' => 'admin@ilerna.com',
            'nombre' => 'admin',
            'apellidos' => 'admin',
            'fecha' => date('Y-m-d H:m:s'),
            'password' => Hash::make('1234'),
            'rol' => '1',
        ]);

        DB::table('users')->insert([
            'id' => 0,
            'nick' => 'user',
            'email' => 'user@ilerna.com',
            'nombre' => 'user',
            'apellidos' => 'user',
            'fecha' => date('Y-m-d H:m:s'),
            'password' => Hash::make('1234'),
            'rol' => '0',
        ]);
    }
}
