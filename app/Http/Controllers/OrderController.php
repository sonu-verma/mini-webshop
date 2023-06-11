<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Product;
use App\Providers\PaymentProviderFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->with('products')->get()->toArray();
        return response()->json($orders);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customer_id' => ['required', Rule::exists(Customer::class, 'id')],
            'product_id' => ['required', Rule::exists(Product::class, 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $order = Order::create([
            'customer_id' => $request->get('customer_id'),
            'payed' => false
        ]);
        $productId = $request->get('product_id');
        if($order){
            if (!$order->products()->find($productId)) {
                $order->products()->attach($productId);
            }
        }
        return response()->json(['message' => 'Order created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => ['required', Rule::exists(Customer::class, 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }


        $order = $this->isValidOrder($id);
        if(!$order){
            return response()->json(['error' => 'invalid order requested.'], 400);
        }
        $order->update($request->all());
        return response()->json(['message' => 'Order updated successfully.']);
    }

    public function show($id)
    {
        $order = $this->isValidOrder($id);
        if(!$order){
            return response()->json(['error' => 'invalid order requested.'], 400);
        }
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = $this->isValidOrder($id);
        if(!$order){
            return response()->json(['error' => 'invalid order requested.'], 400);
        }
        if($order->delete()){
            return response()->json(['message' => 'Order deleted successfully.']);
        }
    }

    public function attachProduct(Request $request, $id)
    {
        $order = Order::where('id',$id)->get()->first();
        if($order){
            if ($order->payed) {
                return response()->json(['error' => 'Cannot add a product to a paid order.'], 400);
            }
        }else{
             return response()->json(['error' => 'invalid order requested.'], 400);
        }

        $productId = $request->input('product_id');

        $product = Product::where('id',$productId)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        if (!$order->products()->find($productId)) {
            $order->products()->attach($productId);
        }

        return response()->json(['message' => 'Product added successfully.']);
    }

    public function payOrder(Request $request, $id)
    {

        $order = $this->isValidOrder($request->get('order_id'));
        if(!$order){
            return response()->json(['error' => 'invalid order requested.'], 400);
        }
        $providerName = 'super';

        try {
            $paymentProvider = PaymentProviderFactory::create($providerName);
            $paymentSuccessful = $paymentProvider->processPayment($request->all());
            if($paymentSuccessful) {
                $order->update(['payed' => true]);
                return response()->json(['message' => 'Payment Successful.']);
            } else {
                return response()->json(['error' => 'Insufficient Funds.'], 400);
            }
        } catch (\InvalidArgumentException $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    private function isValidOrder($id){
        $order = Order::where('id', $id)->get()->first();

        if(!$order){
            return false;
        }
        return $order;
    }

}
