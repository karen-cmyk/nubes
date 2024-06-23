<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'full_name'=> 'Gian Garcia',
            'email' =>'gian08@hotmail.com',
            'password' => Hash::make('12345678'),
         
        
        ])->assignRole('Administrator');


        User::create([
            'full_name'=> 'tony Mendez',
            'email' =>'tonyMendez@hotmail.com',
            'password' => Hash::make('12345678'),
        
        ])->assignRole('Author');

        //esto es para q el factory cree nombre y email falsos
        User::factory(10)->create();

    }
}
