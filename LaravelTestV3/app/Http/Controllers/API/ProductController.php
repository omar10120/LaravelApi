<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class ProductController extends Controller
{
    public function addItem(Request $request){
        $validatedItem= Validator::make($request->all(), 
            [
                'category_id' => 'required|exists:categories,id',
                'name'=>'required',
                'price'=>'required',
                //'item_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'description'=>'required',
            ]);
            if($validatedItem->fails()){
                return response()->json('validation error', 403);
            }
        try{
            $name = $request->name;
            $category_id = $request->category_id;
            $price = $request->price;
            $description = $request->description;
            $is_discount = $request->is_discount;
            $discount = $request->discount;
            $category_name = DB::table('categories')->where('id',$category_id)->first()->name;
            //$image = $request->file('item_image');
            //$image->move(public_path('images'),$name.".".$image->getClientOriginalExtension());
         
            $data = Product::create([
                'name' => $name,
                'category_id'=>$category_id,
                'price'=>$price,
                //'product_image'=> $name.".".$image->getClientOriginalExtension(),
                'description'=>$description ?? '-',
                'is_discount'=>$is_discount ?? false,
                'discount'=>$discount ?? 0.0,
            ]);
           
            return response()->json($data, 200);
            
        }catch(\Throwable $e){
            return response()->json($e->getMessage(), 403);

        }
    }

    public function updateItem(Request $request){
        $validatedItem= Validator::make($request->all(), 
            [
                'id'=>'required|exists:items,id',
                'category_id' => 'required|exists:categories,id',
                'name'=>'required',
                'price'=>'required',
                //'item_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'description'=>'required',
                
            ]);
            if($validatedItem->fails()){
                return response()->json("validate error", 403);
            }
        try{
            $id = $request->id;
            $old_data = Product::find($id);
            $name = $request->name;
            $category_id = $request->category_id;
            $price = $request->price;
            
           // dd($request->has('item_image'));
            $description = $request->description;
            $is_discount = $request->is_discount;
            $discount = $request->discount;
            // if($request->has('item_image')){
            //     $image = $request->file('item_image');
            //     $image->move(public_path('images'),$name.".".$image->getClientOriginalExtension());
            // }
            $data = Product::where('id',$id)->update([
                'name' =>$name, 
                'category_id'=>$category_id,
                'price'=>$price,
               // 'product_image'=>$request->has('item_image') ? $name.".".$image->getClientOriginalExtension() : $old_data->product_image,
                'description'=>$description ?? null,
                'is_discount'=>$is_discount ?? null,
                'discount'=>$discount ?? null,
            ]);
            return response()->json($data, 200);
        }catch(\Throwable $e){
            return response()->json($e->getMessage(), 403);

        }
    }

    public function deleteItem(Request $request){
        $validateCategory= Validator::make($request->all(), 
            [
                
                'id'=>'required|exists:items,id',
                
            ]);
            if($validateCategory->fails()){
                return response()->json($e->getMessage(), 403);
            }
        try{
            
            $item_id=$request->id;
            $old_data =  Product::find($item_id);
            

            //$image_path = $old_data->product_image;  
            // if(File::exists(public_path('images/'.$image_path))) {
            //     File::delete(public_path('images/'.$image_path));

            // }
            Product::where('id',$item_id)->delete();
           return response()->json("deleted successfly", 200);
        }catch(\Throwable $e){
            return response()->json($e->getMessage(), 403);

        }
    }

    public function getAllItems(){
       
        try{
            $data = Product::get();
            // dd($data);
           return response()->json($data, 200);
        }catch(\Throwable $e){
            return response()->json($e->getMessage(), 403);

        }
    }
}
