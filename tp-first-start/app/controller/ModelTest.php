<?php

namespace app\controller;

use app\BaseController;
use app\model\User;
use app\model\Profile;
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

  public function insertJsonUser()
  {
    $userModel = new User();

    // 推荐写法 使用 create 静态方法来创建新增数据
    // 第一个参数是新增数据，第二个是允许写入的字段，第三个是否为 replace 写入
    $userModel::create([
      'username' => '李白003',
      'password' => '123456',
      'gender' => '男',
      'email' => '123456@qq.com',
      'price' => 90,
      'details' => '123',
      'list'    => [
        'username'   => '张三',
        'age'        =>  188
      ],
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

  // 模型查询范围
  public function scopeQuery()
  {
    $queryRes = User::scope('male')->select();
    // 第二种写法
    // $queryRes = User::male()->select();

    // 携带参数查询
    $queryRes = User::scope('email', '345')->select();
    // $queryRes = User::email('345')->select();

    // 多级查询
    $queryRes = User::scope('email', '345')
      ->scope('peice', 80)
      ->select();

    return json($queryRes);
  }

  // 模型搜索器
  public function modelSearch()
  {

    $queryRes = User::withSearch(['email', 'create_time'], [
      'email' => '345',
      'create_time' => ['2016-07-01', '2019-06-01']
    ])->select();

    return json($queryRes);
  }

  // 关联模型
  public function modelRelation()
  {
    $user = User::find(315);

    // halt($user);

    $user->profile;

    // 反向关联
    $profile = Profile::find(37);
    $profile->user;
    // echo $profile->user->username;

    return json($profile);

    return json($user);
  }

  // 模型更多关联 一对多 多条数据->数组
  public function modelMoreRelation()
  {
    $user = User::find(315);
    $user->profileMany;


    return json($user);
  }

  // 关联预加载 减少性能消耗
  // 不关联的情况下 循环会执行N+1次SQL 关联只需两次
  public function modelRelationPreLoad()
  {
    $list = User::with(['profile'])->select([315, 316, 317]);

    // 延迟载入 load

    foreach ($list as $user) {
      dump($user->profile->toArray());
    }
  }

  // 关联统计
  public function modelRelationCount()
  {
    // withMax withMin WithSum withAvg
    $list = User::withCount('profile')->select([315, 316, 317]);
    foreach ($list as $user) {
      // 关联统计的输出采用 关联方法名 + _count
      dump($user->profile_count);
    }

    // 关联输出
    // hidden 可以隐藏字段
    // visible 可以显示字段
    // apend 追加额外字段
  }

  // 多对多关联
  public function relationManyToMany()
  {
    // 一、查询
    $user = User::find(315);
    // // 获取这个用户所有角色
    $roles = $user->roles;

    // halt($roles);

    // 新增 关联
    // $user = User::find(315);
    // $user->roles()->save([
    //   'type' => '测试管理员'
    // ]);
    // 一般新增时通过中间关联表新增即可，即指定id
    // $user->roles()->saveAll([5]);


    // 删除
    // $user = User::find(315);
    // $user->roles()->detach(5);

    return json('');
    // return json($roles);
  }
}
