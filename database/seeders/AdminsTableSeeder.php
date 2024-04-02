<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password=Hash::make('123456');
        $adminRecords=[
            [
                'id' => 1,
                'name' =>'admin',
                'type' =>'admin',
                'password' =>$password,
                'mobile'=>'082240312828',
                'email' =>'admin@gmail.com',
                'image' =>'',
                'status'=>1
            ]
            ];

            Admin::insert($adminRecords);
    }
}
