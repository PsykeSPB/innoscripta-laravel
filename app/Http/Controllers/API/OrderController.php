<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\CurrencyExchangeService as CurService;
use App\Product;
use App\Service;
use App\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
	// If price is need to be modified (eg. discount)
    // it should be done with this function
    /**
     * Modifies price of each product in the order generation process
     * 
     * @param  float $price_mult Multiplicator of the product price
     * @param  float $price_add  Addition to the product price (after multiplication)
     * @return Closure           function - price modificator
     */
	public function modifyPrice(float $price_mult, float $price_add) {
		return function (float $price) use ($price_mult, $price_add) {
			return $price * $price_mult + $price_add;
		};
	}
	// Custom service for price modification should be build

    public function prepare(Request $request, CurService $curService)
    {
    	// Price modificators can be retrieved in request
    	// Or can be calculated based on request parameters
    	$priceMod = $this->modifyPrice(1.0, 0.0);

    	$validator = Validator::make($request->all(), [
    		'cart' => 'required|array',
    		'cart.*' => [ 
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
        			$id = explode('.', $attribute)[1];
        			if (!Product::where('id', $id)->exists()) {
        				$fail("Product id: {$id} not found");
        			}
        		},                
            ],
            'address' => 'sometimes|required|string',
    	]);

    	if ($validator->fails()) {
    		return response()->json($validator->errors(), 422);
    	}

    	$validated = $validator->valid();

    	$products = Product::query()
    		->whereIn('id', array_keys($validated['cart']))
    		->get()
    		->map(function ($product) use ($priceMod, $validated) {
    			$product->price = $priceMod($product->price);
    			$product->quantity = $validated['cart'][$product->id];
    			return $product;
    		});

        if (isset($validated['address'])) {
        	$services = Service::query()
        		->where('id', 1)
        		->get();
        } else {
            $services = collect([]);
        }

    	$total_cost = $products->reduce(function ($sum, $prod) {
    		return $sum + $prod->quantity * $prod->price;
    	}) + $services->reduce(function ($sum, $serv) {
    		return $sum + $serv->price;
    	});

    	return response()->json([
    		'products' => $products,
    		'services' => $services,
    		'total_cost' => [
    			'EUR' => $total_cost,
    			'USD' => $curService->convert('usd', $total_cost),
    		],
    	], 200);
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'cart' => 'required|array',
            'cart.*' => [ 
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    $id = explode('.', $attribute)[1];
                    if (!Product::where('id', $id)->exists()) {
                        $fail("Product id: {$id} not found");
                    }
                },                
            ],
            'address' => 'required|string',
            'phone' => 'required',
            'comment' => 'sometimes|nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->valid();

        try {

            $order = new Order();
            $order->phone = $validated['phone'];
            $order->address = $validated['address'];
            if (isset($validate['comment'])) {
                $order->comment = $validated['comment'];
            }

            DB::transaction(function () use ($validated, &$order) {
                $order->save();

                foreach ($validated['cart'] as $id => $quantity) {
                    $order->products()->attach($id, [
                        'quantity' => $quantity,
                    ]);
                }

                $order->services()->attach('1', [
                    'quantity' => 1,
                ]);
            });

            return response()->json($order, 200);

        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
}
