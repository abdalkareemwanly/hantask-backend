<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $custmers = [
            [
                'name' => 'test',
                'email' => 'test',
                'password' => 'test',
                'image' => 'test',
                'phone' => 'test',
                'address' => 'test',
            ],
        ];
        foreach($custmers as $custmer) {
            Customer::create($custmer);
        }
    }
}
