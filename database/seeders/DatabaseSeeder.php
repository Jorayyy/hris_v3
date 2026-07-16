<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

        // Create standard computational timing intervals
        $weeklyGroup = Group::create(['name' => 'Weekly Shift Workers', 'pay_frequency' => 'weekly']);
        $monthlyGroup = Group::create(['name' => 'Monthly Core Staff', 'pay_frequency' => 'monthly']);
        $customGroup = Group::create(['name' => 'Custom Contractors', 'pay_frequency' => 'custom']);

        User::create([
            'name' => 'Boss Super Admin', 'email' => 'superadmin@hris.com', 'password' => $password,
            'role' => 'super_admin', 'department' => 'Executive', 'job_title' => 'CEO', 'base_salary' => 120000.00, 'hire_date' => '2026-01-01',
        ]);

        User::create([
            'name' => 'Sarah HR Manager', 'email' => 'hr@hris.com', 'password' => $password,
            'role' => 'hr', 'department' => 'Human Resources', 'job_title' => 'HR Specialist', 'base_salary' => 45000.00, 'hire_date' => '2026-03-10',
        ]);

        User::create([
            'name' => 'Alex Accountant', 'email' => 'accounting@hris.com', 'password' => $password,
            'role' => 'accounting', 'department' => 'Finance', 'job_title' => 'Senior Accountant', 'base_salary' => 50000.00, 'hire_date' => '2026-04-01',
        ]);

        // Assign John Doe to the Monthly group
        User::create([
            'name' => 'John Doe', 'email' => 'employee@hris.com', 'password' => $password,
            'role' => 'employee', 'department' => 'Engineering', 'job_title' => 'Software Engineer', 'base_salary' => 60000.00, 'group_id' => $monthlyGroup->id, 'hire_date' => '2026-06-01',
        ]);

        // Create a secondary worker for the Weekly group to test bulk processing
        User::create([
            'name' => 'Jane Smith', 'email' => 'janesmith@hris.com', 'password' => $password,
            'role' => 'employee', 'department' => 'Operations', 'job_title' => 'Support Technician', 'base_salary' => 1500.00, 'group_id' => $weeklyGroup->id, 'hire_date' => '2026-06-15',
        ]);
    }
}
