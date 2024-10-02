<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;

Route::post('/auth/register', [UserController::class, 'createUser']); ///
Route::post('/auth/login', [UserController::class, 'loginUser']);//

Route::group(['middleware' => ['auth:sanctum']], function() {


            
        // user
        Route::get('/user/getAllUser'        , [UserController::class, 'getAllUser']);//
        Route::post('/user/deleteuser'       , [UserController::class, 'deleteuser']);//
        Route::post('/user/addAddress'       , [UserController::class, 'addAddress']);//
        Route::get('/user/getAddresses'      , [UserController::class, 'getAddresses']);//
        Route::post('/user/deleteAddress'    , [UserController::class, 'deleteAddress']);//
        Route::get('/user/logout'            , [UserController::class, 'logout']);//
        Route::get('/user/getUserById'       , [UserController::class, 'getUserById']);//
        Route::post('/user/updateUser'       , [UserController::class, 'updateUser']);//



        //Products
        Route::post('/product/addProduct'   , [ProductController::class, 'addItem']);//
        Route::post('/product/updateProduct', [ProductController::class, 'updateItem']);//
        Route::post('/product/deleteProduct', [ProductController::class, 'deleteItem']);//
        Route::get('/product/getProducts', [ProductController::class, 'deleteItem']);//

        //categories
        Route::post('/category/create'        , [CategoryController::class, 'addCategory']);//
        Route::post('/category/update'        , [CategoryController::class, 'updateCategory']);//
        Route::post('/category/delete'        , [CategoryController::class, 'deleteCategory']);//
        Route::get('/category/getallcategory', [CategoryController::class, 'getAllCategories']);//

        //payments
        Route::get('/order/getAllOrders', [OrderController::class, 'getAllOrders']);//
        Route::post('/order/deleteOrder', [OrderController::class, 'deleteOrder']);//

        //payments
        Route::get('/payment/createPayment', [PaymentController::class, 'createPayment']);//
        Route::post('/order/createOrder', [OrderController::class, 'createOrder']);//
        Route::get('/order/getOrdersByUser', [OrderController::class, 'getOrdersByUser']);//


        //cart
        Route::post('/cart/addToCart', [CartController::class, 'addToCart']);///
        Route::post('/cart/deleteFromCart', [CartController::class, 'deleteFromCart']);//
        Route::get('/cart/deleteCart', [CartController::class, 'deleteCart']);//
        Route::get('/cart/getCart', [CartController::class, 'getCart']);//
        Route::post('/cart/countCart', [CartController::class, 'countCart']);//
    
    

});
