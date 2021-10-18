<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function createOrder(Request $request)
    {
        $user = $request->user();

//         TODO fix validation !!!
        try {
            $validator = Validator::make($request->all(), [
                'items' => ['required', 'array', 'min:1'],
                'items.*.product_id' => ['required', 'exists:products,id'],
                'items.*.quantity' => ['required', 'integer', 'min:1'],
            ])->validate();
        } catch (ValidationException $e) {
            dd($e);
        }

        dd($validator->failed);

        if ($validator->failed()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        DB::beginTransaction();

        try {
            $order = Order::create(['user_id' => $user->id]);

            if (!$order) throw new \Exception('Order was not created.');

            foreach ( $request->get('items') as $item ) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return response()->json(['message' => 'Order was created successfully']);
    }
}
