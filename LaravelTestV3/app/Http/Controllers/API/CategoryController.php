<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    public function getAllCategories(){
       
        try{
            
            $data = Category::get();
            return response()->json($data, 200);
          
        }catch(\Throwable $e){
            return response()->json($e->getMessage(), 401);

        }
    }


    public function addCategory(Request $request){
        $validateCategory= Validator::make($request->all(), 
            [
                'name' => 'required',
            ]);
            if($validateCategory->fails()){
                    return  response()->json('validation Error in product id',403);
            }
        try{
            $name = $request->name;           
            $data = Category::create([
                'name'=>$name,
            ]);
            return  response()->json([
                'The category has been created successfully',
                $data,
           ] );
        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateCategory(Request $request){
        $validateCategory= Validator::make($request->all(), 
            [
                'id'=>'required|exists:categories,id',
                'name'=>'required'

                
            ]);
            if($validateCategory->fails()){
                return response()->json('validation Error',403);
                  
            }
        try{
            $category_id = $request->id;
            $product_id = $request->product_id;
            $name = $request->name;
             Category::where('id',$category_id)->update([
                'name'=>$name,
            ]);
            $data = Category::find($category_id);
            return  response()->json($data, 200);
                
            
        }catch(\Throwable $e){
            return  response()->json($e->getMessage(), 200, $headers);

        }
    }

    public function deleteCategory(Request $request){
        $validateCategory= Validator::make($request->all(), 
            [
                
                'id'=>'required|exists:categories,id',
                
            ]);
            if($validateCategory->fails()){
                return response()->json($data, 200);
            }
        try{
            $category_id=$request->id;
            Category::where('id',$category_id)->delete();
            return response()->json('The category has been deleted successfully',200);

            
           
        }catch(\Throwable $e){
            return response()->json($e->getMessage());}
    }
}
