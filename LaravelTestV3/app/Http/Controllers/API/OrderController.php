<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OrderController extends Controller
{
    
    public function createOrder(Request $request){
       
            $validatedItem= Validator::make($request->all(), 
            [
                'last_name'=>'required',
                'first_name'=>'required',
                'phone'=>'required',
                'adress'=>'required',
                'city'=>'required',
            ]);
            if($validatedItem->fails()){
                return response()->json('validation error', 403);

            }
            try {
            DB::beginTransaction();


            $cartItems= Shopping_cart::where('user_id',Auth::user()->id)->get();
            $itemIds=   $cartItems->pluck('item_id');
            $payment_amount=0;
            foreach ($itemIds as $itemId) {
              $item= Product::where('id',$itemId)->first();
              $itemPrice= $item==null?0:$item->price;
              $payment_amount+=$itemPrice;
            }
           
            
            $payment = Payment::create([
                'payment_amount'=>$payment_amount,
                'delevery_cost'=>0,
                'payment_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id
            ]);
            $address = Address::create([
                'last_name'=>$request->last_name,
                'first_name'=>$request->first_name,
                'adress'=>$request->adress ,
                'phone'=>$request->phone,
                'city'=>$request->city,
                'user_id'=>Auth::user()->id,
                "details"=>$request->details
            ]);
            $totalAmount = $payment->payment_amount + $payment->delevery_cost;
            $order = Order::create([
               'user_id'=>Auth::user()->id,
               'address_id'=>$address->id,
               'order_date'=> Carbon::now(),
               'order_ship_date'=>Carbon::now(),
               'payment_id'=> $payment->id,
               'total_price'=>$totalAmount,
            ]);
            $orderItems=[];

            foreach ($itemIds  as $itemId) {

                $orderItems[]=[
                    'item_id'=>$itemId,
                    'quantity'=>1,
                    'order_id'=>$order->id,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ];

            }
            $order_items = order_item::insert($orderItems);

            Shopping_cart::where('user_id',Auth::user()->id)->delete();
            DB::commit();
          
            return response()->json($order, 200);
            } catch (\Throwable $e) {
                DB::rollBack();
               return response()->json($e->getMessage(), 403);
            }
    }

    public function getAllOrders(){
       
        try{
            
            $data = Order::get();
            return response()->json($data, 200);
        }catch(\Throwable $e){
            
           return response()->json($e->getMessage(), 403);

        }
    }

    public function getOrdersByUser(){
        try{
            $data = Order::where('user_id',Auth::user()->id)->get();
            
            return response()->json($data, 200);
        }catch(\Throwable $e){
           return response()->json($e->getMessage(), 403);

        }
    }
}
