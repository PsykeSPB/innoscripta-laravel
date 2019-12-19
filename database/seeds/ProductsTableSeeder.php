<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pizzas = [
    		[
    			'name' => 'Pepperoni',
    			'description' => 'Delicious classic italian pizza with a little chops of peperoni and deligtfull tomato souce.',
    			'img_url' => 'https://order.dominos.com.au/ManagedAssets/AU/product/P371/AU_P371_en_hero_3876.png?v471011272',
    			'price' => 12.25,
    		],
    		[
    			'name' => 'Reef, Steak & Bacon (5.76kg)',
    			'description' => 'Juicy prawns, seasoned steak & crispy rasher bacon, topped with creamy hollandaise sauce & spring onions.',
    			'img_url' => 'https://order.dominos.com.au/ManagedAssets/AU/product/P362/AU_P362_en_hero_3970.png?v-1691201190',
    			'price' => 40.00,
    		],
    		[
    			'name' => 'Supreme',
    			'description' => 'Crispy rasher bacon, pepperoni & Italian sausage, topped with fresh mushrooms, capsicum, crumbled beef & juicy pineapple, finished with vibrant spring onions & oregano.',
    			'img_url' => 'https://order.dominos.com.au/ManagedAssets/AU/product/P018/AU_P018_en_hero_3876.png?v1832410378',
    			'price' => 22.40,
    		],
    		[
    			'name' => 'Margherita',
    			'description' => 'Diced tomatoes & stretchy mozzarella, topped with oregano.',
    			'img_url' => 'https://order.dominos.com.au/ManagedAssets/AU/product/P301/AU_P301_en_hero_3876.png?v-1734249772',
    			'price' => 10.50,
    		],
    		[
    			'name' => 'Simply Cheese',
    			'description' => 'Simply topped with lots of melted mozzarella goodness.',
    			'img_url' => 'https://order.dominos.com.au/ManagedAssets/AU/product/P015/AU_P015_en_hero_3876.png?v-61415899',
    			'price' => 10.50,
    		],
    		[
    			'name' => 'Ham & Cheese',
    			'description' => 'Strips of smoky leg ham & creamy mozzarella',
    			'img_url' => 'https://order.dominos.com.au/ManagedAssets/AU/product/P099/AU_P099_en_hero_3876.png?v-465723440',
    			'price' => 12.25,
    		],
    		[
    			'name' => 'Fire Breather',
    			'description' => "Crumbled pork & fennel sausage, Domino's pepperoni, seasoned ground beef, fiery jalapenos, tomato & sliced red onion with a spicy hit of chilli flakes.",
    			'img_url' => 'https://order.dominos.com.au/ManagedAssets/AU/product/P067/AU_P067_en_hero_3876.png?v-1208460108',
    			'price' => 25.00,
    		],
    		[
    			'name' => 'Loaded Burger',
    			'description' => 'Seasoned ground beef, American cheddar cheese, diced tomato & red onion, all finished with special burger sauce & spring onions.',
    			'img_url' => 'https://order.dominos.com.au/ManagedAssets/AU/product/P380/AU_P380_en_hero_3876.png?v17997532',
    			'price' => 28.32,
    		],
    	];

    	foreach ($pizzas as $p) {
        	Product::create($p);
    	}
    }
}
