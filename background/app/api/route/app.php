<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;



Route::get('index', 'Index/index');

Route::get('swipers', 'Swiper/getSwipers')->middleware(\app\middleware\Check::class);
Route::get('cats', 'Category/getCats')->middleware(\app\middleware\Check::class);
Route::get('subcats/:id', 'Category/getSubcats')->middleware(\app\middleware\Check::class);
Route::get('indexgoods','Goods/getIndexGoods')->middleware(\app\middleware\Check::class);
Route::get('cat_goods/:id','Goods/getCatGoods')->middleware(\app\middleware\Check::class);
Route::get('goods/:id','Goods/getGoodsDetail')->middleware(\app\middleware\Check::class);
Route::get('goodss/:id','Goods/getGoods')->middleware(\app\middleware\Api::class);
Route::post('code','Login/sendCode')->middleware(\app\middleware\Check::class);
Route::post('login','Login/login')->middleware(\app\middleware\Check::class);
Route::post('refreshToken','Login/refreshToken');
Route::get('user','User/getUser')->middleware(\app\middleware\Api::class);
Route::post('addr','Address/saveAddr')->middleware(\app\middleware\Api::class);
Route::get('addr','Address/getAddr')->middleware(\app\middleware\Api::class);
Route::get('one_addr','Address/getOneAddr')->middleware(\app\middleware\Api::class);
Route::delete('addr/:id','Address/delAddr')->middleware(\app\middleware\Api::class);
Route::post('order','Order/saveOrder')->middleware(\app\middleware\Api::class);
Route::get('order/:order_type','Order/getOrder')->middleware(\app\middleware\Api::class);
Route::get('order/receive/:id','Order/receive')->middleware(\app\middleware\Api::class);
Route::post('pay','Pay/pay')->middleware(\app\middleware\Api::class);
Route::post('ali_callback','Pay/aliCallback');
Route::post('wx_callback','Pay/wxCallback');
Route::get('express/:id','Express/getExp')->middleware(\app\middleware\Api::class);
Route::post('comment','Comment/saveComment')->middleware(\app\middleware\Api::class);
Route::get('comment/:id','Comment/getComment')->middleware(\app\middleware\Check::class);

