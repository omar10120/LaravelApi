<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;

class UserController extends Controller
{

    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [   
                'name' => 'required',
                'email' => 'required|email',
                
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            // $User = Auth::user();
            
            $user = User::where('id',$id )->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            if ($request->has('password')) {
                $User->password = Hash::make($request->password);
                $User->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'User updated Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User logged out  Successfully',
            'data' => "you are logged out"
        ], 200);
    }

    public function addAddress(Request $request){
        $validateCategory= Validator::make($request->all(), 
            [
                'street_name'=>'required',
                'details'=>'required'
            ]);
            if($validateCategory->fails()){
                // $validtionMessages = $validateCategory->errors();
                    return $this->failure('validation Error',403);
            }
            try {
                $data = Address::create([
                    'user_id'=>Auth::user()->id,
                    'street_name'=>$request->street_name,
                    'details'=>$request->details
                ]);
                return $this->success(
                    'The address has been created successfully',
                    $data,
                );
            } catch (\Throwable $e) {
                //throw $th;
                return $this->failure($e->getMessage());
            }
    }

    public function getAddress(){
        try {
            $data = User::find(1)->Addresses;
            return  $this->success(
                'The addresses has been obtained successfully',
                $data,
            );
        } catch (\Throwable $e) {
            return $this->failure($e->getMessage());
        }
        
    }

    public function deleteAddress(Request $request){
        $validateCategory= Validator::make($request->all(), 
            [
                'address_id'=>'required|exists:addresses,id',
            ]);
            if($validateCategory->fails()){
                // $validtionMessages = $validateCategory->errors();
                    return $this->failure('validation Error',403);
            }
        try {
            Address::where('id',$request->address_id)->delete();
            return  $this->success(
                'The addresses has been deleted successfully',
                
            );
        } catch (\Throwable $e) {
             return $this->failure($e->getMessage());
        }
    }

    public function getAllUser(){
       
        try{
            
            $data = User::get();
            return $this->success(
                'The User has been obtained successfully',
                $data,
            );
        }catch(\Throwable $e){
            
            return $this->failure($e->getMessage());

        }
    }

    public function getUserById(Request $request){
       
        try{
          
            $data = User::where('id', Auth::user()->id)->get();
            return $this->success(
                'The user by id has been obtained successfully',
                $data,
            );
        }catch(\Throwable $e){
            
            return $this->failure($e->getMessage());

        }
    }

    public function deleteuser(Request $request){
        $validateCategory= Validator::make($request->all(), 
            [
                
                'id'=>'required',
                
            ]);
            if($validateCategory->fails()){
                    return $this->failure('validation Error',403);
            }
        try{
            
            $User_id=$request->id;
           
            User::where('id',$User_id)->delete();
            return $this->success(
                'The user has been deleted successfully',
            
            );

        }catch(\Throwable $e){
            return $this->failure($e->getMessage());

        }
    }   
}