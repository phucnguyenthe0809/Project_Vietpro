<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ----------------------> LÝ THUYẾT

// chỗ này sẽ thực hiện 1 số ví dụ cho lý thuyết

//-------------------------> PROJECT
// Frontend
Route::get('', 'frontend\indexController@getIndex');
Route::get('contact.html', 'frontend\indexController@getContact');
Route::get('about.html','frontend\indexController@getAbout' );

Route::get('{slug_cate}.html','frontend\IndexController@GetPrdCate');
Route::get('filter','frontend\IndexController@GetFilter');
//Cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('', 'frontend\cartController@getCart');
    Route::get('add','frontend\CartController@addCart');
    Route::get('update/{rowId}/{qty}','frontend\CartController@updateCart');
    Route::get('del/{rowId}','frontend\CartController@delCart');
});

// CheckOut
Route::group(['prefix' => 'checkout'], function () {
    Route::get('', 'frontend\checkOutController@getCheckOut');
    Route::post('', 'frontend\checkOutController@postCheckOut');
    Route::get('complete/{order_id}','frontend\checkOutController@getComplete');
});



//Product in SHop
Route::group(['prefix' => 'product'], function () {
    Route::get('','frontend\productController@getShop');
    Route::get('{slug_prd}.html', 'frontend\productController@getDetail');
});


Route::get('login', 'frontend\loginController@getLogin');
Route::post('login', 'frontend\loginController@postLogin');

//ADMIN
Route::group(['prefix' => 'admin'], function () {
    Route::get('',  'backend\indexController@getIndex');

    //product
    Route::group(['prefix' => 'product'], function () {
        Route::get('',  'backend\productController@getListProduct');
        Route::get('add',  'backend\productController@getAddProduct');
        Route::post('add',  'backend\productController@postAddProduct');
        Route::get('edit/{idPrd}',  'backend\productController@getEditProduct');
        Route::post('edit/{idPrd}',  'backend\productController@postEditProduct');
        Route::get('del/{idPrd}',  'backend\productController@delProduct');
    });
 

    //category
    Route::group(['prefix' => 'category'], function () {
        Route::get('','backend\categoryController@getCategory' );
        Route::post('','backend\categoryController@postCategory' );
        Route::get('edit/{idcate}', 'backend\categoryController@getEditCategory');
        Route::post('edit/{idCate}','backend\categoryController@postEditCategory' );
        Route::get('del/{idCate}','backend\categoryController@delCate');
    });
    
    //order
   Route::group(['prefix' => 'order'], function () {
        Route::get('','backend\orderController@getOrder' );
        Route::get('detail/{order_id}','backend\orderController@getdetail' );
        Route::get('paid/{order_id}','Backend\OrderController@paid');
        Route::get('processed', 'backend\orderController@getProcessed');
   });

   
    // user
    Route::group(['prefix' => 'user'], function () {
        Route::get('',  'backend\userController@getUser');
        Route::get('add', 'backend\userController@getAddUser' );
        Route::post('add', 'backend\userController@postAddUser' );
        Route::get('edit/{idUser}', 'backend\userController@geteditUser' );
        Route::post('edit/{idUser}', 'backend\userController@postEditUser' );
        Route::get('del/{idUser}', 'backend\userController@delUser' );
    });
    
    
});
