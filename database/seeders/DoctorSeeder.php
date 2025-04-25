<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialists = ['Skin', 'Medical', 'Child','Kidney','Dentist','Heart'];
        foreach ($specialists as $specialist) {
            User::create([
                'name' => $specialist.' Specialist',
                'email' => lcfirst($specialist).'specialist@gmail.com',
                'password' => bcrypt(123456),
                'speciality' => $specialist,
                'role' => 'doctor'
            ]);
        }
    }
}
