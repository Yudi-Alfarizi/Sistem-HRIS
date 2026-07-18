<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class HumanResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();  // Initialize Faker

        // Seed Departments table
        DB::table('departments')->insert([
            ['name' => 'HR', 'description' => 'Human Resources', 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'IT', 'description' => 'Information Technology', 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Sales', 'description' => 'Sales and Marketing', 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Seed Roles table
        DB::table('roles')->insert([
            ['title' => 'Manager', 'description' => 'Menangani Manajemen Tim', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Developer', 'description' => 'Menangani Pengembangan Perangkat Lunak', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Salesperson', 'description' => 'Menangani Penjualan dan Komunikasi Klien', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Seed Employees table
        DB::table('employees')->insert([
            [
                'fullname' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'birth_date' => $faker->dateTimeBetween('-35 years', '-20 years'),
                'hire_date' => Carbon::now(),
                'department_id' => 1,  // HR
                'role_id' => 1,        // Manager
                'status' => 'active',
                'salary' => $faker->randomFloat(2, 3500, 7000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
            [
                'fullname' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'birth_date' => $faker->dateTimeBetween('-50 years', '-30 years'),
                'hire_date' => Carbon::now(),
                'department_id' => 2,  // IT
                'role_id' => 2,        // Developer
                'status' => 'active',
                'salary' => $faker->randomFloat(2, 4500, 7500),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
        ]);

        // Seed Tasks table
        DB::table('tasks')->insert([
            [
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'assigned_to' => 1,
                'due_date' => Carbon::parse('2026-07-11'),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'assigned_to' => 2,
                'due_date' => Carbon::parse('2026-07-20'),
                'status' => 'in-progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed Payroll table
        DB::table('payroll')->insert([
            [
                'employee_id' => 1, 
                'salary' => $faker->randomFloat(2, 4500, 7000),
                'bonuses' => $faker->randomFloat(2, 150, 550),
                'deductions' => $faker->randomFloat(2, 50, 150),
                'net_salary' => $faker->randomFloat(2, 4500, 7000),
                'pay_date' => Carbon::parse('2026-07-25'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'employee_id' => 2, 
                'salary' => $faker->randomFloat(2, 4000, 7000),
                'bonuses' => $faker->randomFloat(2, 100, 500),
                'deductions' => $faker->randomFloat(2, 50, 200),
                'net_salary' => $faker->randomFloat(2, 4000, 7000),
                'pay_date' => Carbon::parse('2026-07-25'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed Presences table
        DB::table('presences')->insert([
            [
                'employee_id' => 1,
                'check_in' => Carbon::parse('2026-07-10 09:00:00'),
                'check_out' => Carbon::parse('2026-07-10 17:00:00'),
                'date' => Carbon::parse('2026-07-10'),
                'status' => 'hadir',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'employee_id' => 2,
                'check_in' => Carbon::parse('2026-07-10 09:30:00'),
                'check_out' => Carbon::parse('2026-07-10 17:00:00'),
                'date' => Carbon::parse('2026-07-10'),
                'status' => 'hadir',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed Leave Requests table
        DB::table('leave_requests')->insert([
            [
                'employee_id' => 1,
                'leave_type' => 'Liburan',
                'start_date' => Carbon::parse('2026-08-12'),
                'end_date' => Carbon::parse('2026-08-13'),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'employee_id' => 2,
                'leave_type' => 'Sakit',
                'start_date' => Carbon::parse('2026-08-15'),
                'end_date' => Carbon::parse('2026-08-18'),
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
