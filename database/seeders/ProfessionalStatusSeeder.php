<?php

namespace Database\Seeders;

use App\Models\ProfessionalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            [
                'company_status' => 'I have just registered my company'
            ],
            [
                'company_status' => 'My company has been in existence for less than 6 months'
            ],
            [
                'company_status' => 'My company has existed for between 6 months and a year'
            ],
            [
                'company_status' => 'My company has been around for over a year'
            ],
            [
                'company_status' => 'I dont have a company'
            ],
        ];
        foreach($rows as $row) {
            ProfessionalStatus::create($row);
        }
    }
}
