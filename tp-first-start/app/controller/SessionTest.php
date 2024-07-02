<?php

namespace app\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\Session;

class SessionTest extends BaseController
{
  public function index()
  {
    return 'hello session!!';
  }

  public function setSession()
  {
    Session::set('username', 'sean');
    Session::set('usercount', 20);
    return Session::get('username');
  }

  public function getSession()
  {
    // 读取所有 session 的值 第二个参数为默认值
    $allSession = Session::all();
    // 读取 session 参数为名称
    $reqSession = Request::session('username');

    return json([
      'allSession'  => $allSession,
      'reqSession'  => $reqSession,
    ]);
  }

  public function optionSession()
  {
    // 判断是否有值
    $hasSession = Session::has('username');
    // 删除
    $delSession = Session::delete('username');
    // 取值后删除 无值则为 null
    $pullSession = Session::pull('username');
    // 清除整个Session
    Session::clear();
  }
}
