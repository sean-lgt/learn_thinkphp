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

Route::get('think', function () {
  return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

Route::get('routerTest/index', 'routerTest/index');
// Route::get('routerTest/details/:id', 'routerTest/details');
// 使用路由变量规则 id只能为数字 数组方式传递
Route::get('routerTest/details/:id', 'routerTest/details')->pattern(['id' => '\d+']);
