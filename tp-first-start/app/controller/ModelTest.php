<?php

namespace app\controller;

use app\BaseController;
use app\model\User;
use think\facade\Db;


class ModelTest extends BaseController
{
  public function index()
  {
    $queryRes = User::select();

    return json($queryRes);
  }

  public function getUserInfo()
  {
    $queryRes = User::find(27);

    return json($queryRes);
  }

  // 新增用户
  public function insertUser()
  {
    $userModel = new User();

    // 赋值
    $userModel->username  =  '李白';
    $userModel->password  =  '123456';
    $userModel->gender    =  '男';
    $userModel->email     =  '123456@qq.com';
    $userModel->price     =  90;
    $userModel->details   =  '123';

    // 新增报错
    // $userModel->save();

    // 也可以数组的方式来新增数据
    // $data = [
    //   'username' => '李白002',
    //   'password' => '123456',
    //   'gender' => '男',
    //   'email' => '123456@qq.com',
    //   'price' => 90,
    //   'details' => '123',
    // ];
    // $userModel->save($data);


    // 推荐写法 使用 create 静态方法来创建新增数据
    // 第一个参数是新增数据，第二个是允许写入的字段，第三个是否为 replace 写入
    $userModel::create([
      'username' => '李白003',
      'password' => '123456',
      'gender' => '男',
      'email' => '123456@qq.com',
      'price' => 90,
      'details' => '123',
    ], [], false);

    return json('新增成功');
  }

  // 删除用户
  public function deleteUser()
  {
    $user = User::find(314);

    $user->delete();

    // 可以使用静态方法调用 destory 通过主键删除数据，传入数组则可以批量删除数据
    // User::destroy(314);

    // 通过数据库类的查询条件删除
    // User::where('id',324)->delete();

    // 通过闭包的方式进行删除
    // User::destroy(function ($query) {
    //   $query->where('id', 324);
    // });


    return json('删除成功');
  }

  // 更新用户
  public function updateUser()
  {
    // 使用 find 方法获取数据，然后通过 save 方法保存修改
    $user = User::find(315);
    $user->username  =  '李白315';
    $user->email  =  '315@qq.com';
    $user->save();

    // 通过 where 方法结合 find 方法的查询条件获取数据，进行修改
    $user = User::where('username', '李白315')->find();
    $user->email  =  '3155@qq.com';

    // Db::raw 可以执行 SQL 函数
    $user->price  =  DB::raw('price+5');

    // save只会更新变化的数据 在前端调用 force则会强制更新
    // $user->force()->save();

    // 通过 saveAll 方法可以批量修改数据

    $user->save();

    // 使用静态方法 update
    // 参数，条件，更新的字段值

    User::update([
      'id'       =>  315,
      'username' =>  '李白update'
    ]);

    User::update([
      "username"  =>  "李白update*2"
    ], ['id' => 315]);

    User::update([
      "username"  =>  "李白update*2"
    ], ['id' => 315], ['username']);


    return json('更新成功');
  }

  // 查询用户
  public function queryUser()
  {
    // 通过find方法
    $userInfo = User::find(315);
    // 也可以使用 where 方法进行条件筛选查询数据
    $userInfo = User::where('username', '李白5555')->findOrEmpty();

    // 可以使用 isEmpty 判断是否为空模型
    // if ($userInfo->isEmpty()) {
    //   return json('没有数据');
    // }

    // 使用 select 方法，查询多条指定id的字段
    $userInfo = User::select([313, 315, 316]);
    // foreach ($userInfo  as $key => $value) {
    //   echo $value->username . "\n";
    // }

    // 模型方法可以使用 where 连缀查询，和数据库查询方式一样
    $userInfo = User::where('status', 0)
      ->limit(3)
      ->order('id', 'desc')
      ->select();

    // 获取某个字段 value 或者某个列 column 的值
    $testValue = User::where('id', 315)->value('email');
    $testValue2 = User::whereIn('id', [315, 316, 306])->column('username', 'id');

    // 支持动态查询 getBy**  **字段名
    $emailValue = User::getByUsername('李白');

    // 使用 chunk 方法可以分批处理数据
    // 可以利用游标进行查询减少性能开销 cursor

    // halt($testValue);

    return json($userInfo);
  }

  // 获取器的使用
  public function getModelAttr()
  {
    $user = User::find(315);
    // $statusName = $user->status;
    // $statusName = $user->nothing;
    // halt($user);
    // echo($statusName);

    // 获取原始数据
    // $orginData = $user->getData();

    // 使用 WithAttr 在控制器端实现动态获取器
    // $user = User::withAttr('status', function ($value) {
    //   $arr = [-1 => '删除', 0 => '禁用', 1 => '正常'];
    //   return $arr[$value];
    // })->select();


    return json($user);
  }
}
