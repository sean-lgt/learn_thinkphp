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
    // 将数据集转换为数组
    //  $userList= Db::name('user')->find()->toArray();
    return json($userList);
  }

  public function getUser()
  {
    $userList = User::select();
    return json($userList);
  }

  public function getUserById($id)
  {
    // halt()
    $userDetail = Db::name('user')->where('id', $id)->find();
    // 查询不存在时抛出异常
    // $userDetail = Db::name('user')->where('id', $id)->findOrFail();
    // 查询不存在时返回空
    // $userDetail = Db::name('user')->where('id', $id)->findOrEmpty();
    // 打印sql语句真实执行
    // Db::getLastSql();

    return json($userDetail);
  }

  public function getUserNameById($id)
  {
    // halt()
    // 查询具体字段值
    // $userName = Db::name('user')->where('id', $id)->value('username');
    // return json($userName);

    // 指定具体字段，返回列
    $userNameList = Db::name('user')->column('username', 'id');
    return json($userNameList);
  }

  public function getUserListChunk()
  {
    Db::name('user')->chunk(3, function ($users) {
      foreach ($users as $user) {
        dump($user);
      }
      echo 1;
    });
  }

  // 利用游标查询 减少内存开销
  public function getUserListCursor()
  {
    $cursor = Db::name('user')->cursor();
    foreach ($cursor as $user) {
      dump($user);
    }
  }

  // 保留查询对象 减少内存消耗
  public function getUserMoreInfo()
  {
    $userQuery = DB::name('user');

    $userFind = $userQuery->where('id', 27)->find();
    // 使用同一个查询对象，会保留上一次查询参数
    // $userList = $userQuery->select();
    // removeOption 清理缓存的查询参数
    $userList = $userQuery->removeOption()->select();
    // dump($userList);
    $data['find'] = $userFind;
    $data['list'] = $userList;

    return json($data);
  }
}
