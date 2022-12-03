<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            "name"=>"Monthly",
            "price"=>5.00,
            "type"=>"month",
            "quantity"=>1
        ]);
        Plan::create([
            "name"=>"Yearly",
            "price"=>36.00,
            "type"=>"year",
             "quantity"=>12
        ]);
    }
}
