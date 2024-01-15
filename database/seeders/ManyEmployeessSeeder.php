<?php

namespace Database\Seeders;

use App\Models\ManyEmployeess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManyEmployeessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            [
                'employee_status' => 'Without Employees'
            ],
            [
                'employee_status' => '1 Employee'
            ],
            [
                'employee_status' => '2 To 10 Employees'
            ],
            [
                'employee_status' => 'More Than 10 Employees'
            ],
        ];
        foreach($rows as $row) {
            ManyEmployeess::create($row);
        }
    }
}
