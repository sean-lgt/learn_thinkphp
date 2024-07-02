<?php

namespace app\controller;

use app\BaseController;
use think\facade\Cookie;

class CookieTest extends BaseController
{
  public function index()
  {
    return 'hello cookie!!';
  }

  public function setCookie()
  {
    Cookie::set('username', 'sean', 3600);  // 3600秒

    // 设置永久保存
    Cookie::forever('ever', '123321');
  }

  public function getCookie()
  {
    $cookie = Cookie::get('username');

    // 判断是否有
    $has = Cookie::has('test');
    // 删除
    Cookie::delete('test');

    return json([
      'cookie'  => $cookie,
      'has'     => $has,
    ]);
  }
}
