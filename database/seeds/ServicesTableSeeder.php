<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
    		'name' => 'delivery',
    		'description' => 'Standart delivery by curier to your address.',
    		'img_url' => 'https://cdn1.iconfinder.com/data/icons/logistics-transportation-vehicles/202/logistic-shipping-vehicles-002-512.png',
    		'price' => 5.00,
    	]);
    }
}
