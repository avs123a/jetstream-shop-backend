<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function createOrder(Request $request)
    {
        $user = $request->user();
        // TODO get user ID from AUTH SSTEM !!!
//        Validator::make($request->all(), [
////            'user_id' => ['required', 'string'],
//            'slug' => ['required', 'string'],
//            'description' => ['nullable', 'string'],
//            'category_id' => ['required', 'integer', 'exists:categories,id'],
//            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
//            'enabled' => ['nullable', 'integer', 'in:0,1'],
//        ])->validate();

//        $order = Order::create([
//            ''
//        ])

//        if (!$order) return response()->json(['error' => 'Order was not created.'], 500);



    }
}
