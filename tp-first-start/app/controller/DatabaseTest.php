<?php

namespace app\controller;

use app\BaseController;
use think\facade\Db;

use app\model\User;

class DatabaseTest extends BaseController
{
  public function index()
  {
    // 使用 table 方法需要手动增加前缀
    // $userList = Db::table('tp_user')->select();
    // 获取数据库配置
    $config = Db::getConfig();
    // 使用 name 方法需要手动增加前缀
    $userList = Db::name('user')->select();
    return json($userList);
  }

  public function getUser()
  {
    $userList = User::select();
    return json($userList);
  }
}
