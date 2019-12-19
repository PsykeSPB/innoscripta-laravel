<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
	/**
	 * Returns list of all available products in store
	 * 
	 * @param  Request $request
	 */
    public function index(Request $request)
    {
    	return Product::paginate($request->input('per_page', 15));
    }
}
