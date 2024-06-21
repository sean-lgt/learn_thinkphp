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

  public function addUserInfo()
  {
    $data = [
      'username'   =>  '张三测试',
      'password'   =>  '123456',
      'gender'     =>  '女',
      'email'      =>  '123456@qq.com',
      'price'      =>  90,
      'details'    =>  '123'
    ];

    // strict(false)->insert($data) 可以强制新增并忽略不存在的字段
    $addResult = Db::name('user')->insert($data);
    // replace 如果主键存在则修改，否则新增
    // insertGetId() 新增数据成功后返回当前id
    if ($addResult === 1) {
      return '成功';
    } else {
      return '失败';
    }
  }

  public function addAllUserInfo()
  {
    $allData = [
      [
        'username'   =>  '张三测试001',
        'password'   =>  '123456',
        'gender'     =>  '女',
        'email'      =>  '123456@qq.com',
        'price'      =>  90,
        'details'    =>  '123'
      ],
      [
        'username'   =>  '张三测试002',
        'password'   =>  '123456',
        'gender'     =>  '女',
        'email'      =>  '123456@qq.com',
        'price'      =>  90,
        'details'    =>  '123'
      ],
      [
        'username'   =>  '张三测试003',
        'password'   =>  '123456',
        'gender'     =>  '女',
        'email'      =>  '123456@qq.com',
        'price'      =>  90,
        'details'    =>  '123'
      ],
    ];

    $addResult = Db::name('user')->insertAll($allData);

    if ($addResult > 0) {
      return '批量成功';
    } else {
      return '批量失败';
    }
  }

  public function saveUserInfo()
  {
    $data = [
      // 'id'         =>  306,  // 新增或者修改由主键是否存在决定
      'username'   =>  '李四测试306',
      'password'   =>  '123456',
      'gender'     =>  '女',
      'email'      =>  '123456@qq.com',
      'price'      =>  90,
      'details'    =>  '123'
    ];

    // save 自行判断是新增或者修改  由是否有主键决定
    $addResult = Db::name('user')->save($data);

    if ($addResult === 1) {
      return 'save成功';
    } else {
      return 'save失败';
    }
  }

  public function updateUserInfo()
  {
    $data = [
      // 'id'         =>  305,  // 如果信息已经包含主键，则可以忽略where
      'password'   =>  '12345678',
    ];

    $updateRes = Db::name('user')->where('id', 305)->update($data);

    // 如果想让一些字段执行SQL函数，可以使用exp()方法实现
    // $updateRes = Db::name('user')->where('id', 305)->exp('email', 'UPPER(email)')->update($data);

    // 如果要自增、自减某个字段，可以使用 inc/dec 方法，并支持自定义步长
    // $updateRes = Db::name('user')->where('id', 305)->inc('price', 10)->dec('status', 2)->update();

    if ($updateRes > 0) {
      return 'update成功';
    } else {
      return 'update失败';
    }
  }
}
