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


// 多级路由访问
Route::get('group/details/:id', 'group.Blog/details');
// 对于地址，还有一种完整路径去执行操作方法，完整类名@操作方法
Route::get('group/test', '\app\controller\group\Blog@test');
// 使用 redirect实现重定向跳转 第三个参数为状态码
Route::redirect('group/redirect', '/', 302);


// 路由参数
// ext 方法可以检测URL后缀
Route::get('hello01/:name', 'index/hello')->ext('html');
// https 方法作用是检测是否为 https 请求
Route::get('group/test/01', '\app\controller\group\Blog@test')->https();
// denyExt 方法可以禁止某些后缀的使用
Route::get('group/test/01', '\app\controller\group\Blog@test')->denyExt('gif|png');
// domain 方法可以限制域名访问
// filter 方法可以对额外参数进行检测
// append 方法可以追加额外参数
// options 可以进行所有参数的配置


// 路由的域名 顶级域名 多个二级域名
Route::domain('test.com', function () {
  // 路由写在这里
});

// 跨域请求 allowCrossDomain 参数信息可以放在[]
Route::get('hello/cross/:name', 'index/hello')->allowCrossDomain();


// 路由分组
// group 相同前缀的路由合并分组，简化路由定义，提高匹配效率

Route::group('group', function () {
  Route::get('testgroup/:id', 'index/hello');
});
// 也可以省去第一参数，让分组路由更灵活
// 使用 prefix 可以省略掉分组地址里的控制器
Route::group('group2', function () {
  Route::get('testgroup/:id', 'hello');
})->prefix('Index');
