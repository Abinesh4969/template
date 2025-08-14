<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $plans = [
            [
                'name' => 'Silver',
                'price' => 99.00,
                'limit' => 10,
                'currency' => 'INR',
                'duration' => '10',
                'razorpay_plan_id' => null, // to be updated after Razorpay API call
            ],
            [
                'name' => 'Gold',
                'price' => 199.00,
                'limit' => 20,
                'currency' => 'INR',
                'duration' => '20',
                'razorpay_plan_id' => null,
            ],
            [
                'name' => 'Platinum',
                'price' => 299.00,
                'limit' => 30,
                'currency' => 'INR',
                'duration' => '30',
                'razorpay_plan_id' => null,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::firstOrCreate(['name' => $plan['name']], $plan);
        }
    
    }
}
