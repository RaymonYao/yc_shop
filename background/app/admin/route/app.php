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
use app\middleware\Login;
use think\facade\Route;

Route::get('index', 'Index/index')->middleware(Login::class);
Route::get('welcome', 'Index/welcome')->middleware(Login::class);
Route::resource('swiper', 'Swiper')->pattern(['id' => '\d+'])->middleware(Login::class);
Route::post('system/upload', 'System/upload')->middleware(Login::class);
Route::get('swiper/getSwiperList', 'Swiper/getSwiperList')->middleware(Login::class);
Route::post('swiper/isShow', 'Swiper/isShow')->middleware(Login::class);
Route::resource('category', 'Category')->pattern(['id' => '\d+'])->middleware(Login::class);
Route::get('category/get_cats', 'Category/getCats')->middleware(Login::class);
Route::post('category/is_show', 'Category/isShow')->middleware(Login::class);
Route::resource('goods', 'Goods')->pattern(['id' => '\d+'])->middleware(Login::class);
Route::post('goods/upload', 'Goods/upload')->middleware(Login::class);
Route::post('goods/upload_goods', 'Goods/uploadGoods')->middleware(Login::class);
Route::get('goods/get_goods', 'Goods/getGoods')->middleware(Login::class);
Route::post('goods/is_show', 'Goods/isShow')->middleware(Login::class);
Route::get('user/index', 'User/index')->middleware(Login::class);
Route::get('user/get_user', 'User/getUser')->middleware(Login::class);
Route::post('user/is_show', 'User/isShow')->middleware(Login::class);
Route::get('order/index', 'Order/index')->middleware(Login::class);
Route::get('order/get_order', 'Order/getOrder')->middleware(Login::class);
Route::get('order/exp/:id', 'Order/exp')->middleware(Login::class);
Route::post('order/save_exp', 'Order/saveExp')->middleware(Login::class);

Route::get('logout', 'Login/logout');
Route::rule('login', 'Login/login','GET|POST');
Route::get('captcha', 'Login/captcha');

