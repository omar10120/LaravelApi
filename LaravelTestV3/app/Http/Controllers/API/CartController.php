<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Shopping_cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Product;
class CartController extends Controller
{
    public function addToCart(Request $request){
        $validate= Validator::make($request->all(), 
        [
            'product_id' => 'required|exists:products,id',
            'count' ,
        ]);
        if($validate->fails()){
                return response()->json("validate error");
        }try{
            
            $data = Shopping_cart::create([
                'user_id'=>Auth::user()->id,
                'product_id'=>$request->product_id,
                'count'=>$request->count == null ? '1' : $request->count,
            ]);
           return response()->json($data, 200);
        }catch(\Throwable $e){
            return response()->json($e->getMessage(), 400);

        }
            
    }
    public function deleteFromCart(Request $request){
        $validate= Validator::make($request->all(), 
        [
            'cart_product_id' => 'required|exists:shopping_carts,id',
        ]);
        if($validate->fails()){
                return response()->json("validate error");
        }
        try{
            Shopping_cart::where('id',$request->cart_product_id)->delete();
          
            return response()->json('The Item has been deleted from cart successfully', 200);
        }catch(\Throwable $e){
            return response()->json($e->getMessage(), 200);

        }
            
    }

    public function countCart(Request $request){
        $validate= Validator::make($request->all(), 
        [
            'cart_product_id' => 'required|exists:shopping_carts,id',
            'count' => 'required',
        ]);
        if($validate->fails()){
                return response()->json("validate error");
        }
        try{
            Shopping_cart::where('id',$request->cart_product_id)->update([
                'count' => $request->count
            ]);
            return response()->json(
                'The Item count updating successfully',200
                
            );
        }catch(\Throwable $e){
            return response()->json($e->getMessage(), 200);

        }
            
    }

    public function deleteCart(){
        try{
            Shopping_cart::where('user_id',Auth::user()->id)->delete();
            return response()->json(
                'The cart has been deleted successfully',
                
            );
        }catch(\Throwable $e){
            return response()->json($e->getMessage(), 200);
        }
            
    }
    public function getCart(){
        try{
            $data = Shopping_cart::where('user_id',Auth::user()->id)->get();
            $items = [];
            $totalSum=0.0;
            foreach($data as $product_id){
                $item = Product::where('id',$product_id->product_id)->first();
                $item->cart_id= $product_id->id;
                $item->count = $product_id->count;
                $totalSum+=($item->price)*($product_id->count);
                array_push($items, $item);
            }
            
           return response()->json($data, 200);
        }catch(\Throwable $e){
            
            return response()->json($e->getMessage(), 400);

            
        }
    }
}
