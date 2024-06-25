<?php

namespace app\controller;

use app\BaseController;
use think\facade\Db;

use app\model\User;
use think\db\Where;

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
      'username'   =>  '李四11测试13',
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

    // 如果想让一些字段执行SQL函数，可以使用exp()方法实现  ::raw方法可以更简单的实现
    // $updateRes = Db::name('user')->where('id', 305)->exp('email', 'UPPER(email)')->update($data);

    // 如果要自增、自减某个字段，可以使用 inc/dec 方法，并支持自定义步长
    // $updateRes = Db::name('user')->where('id', 305)->inc('price', 10)->dec('status', 2)->update();

    if ($updateRes > 0) {
      return 'update成功';
    } else {
      return 'update失败';
    }
  }

  public function deleteUser()
  {
    // 直接通过 delete 删除主键
    // $delRes = Db::name('user')->delete(307);

    // 根据主键，还可以删除多条记录
    // $delRes = Db::name('user')->delete([308, 309]);

    // 正常情况下，通过 where方法来删除
    $delRes = Db::name('user')->where('id', 310)->delete();

    // 通过 true 参数删除数据表所有数据
    // $delRes = Db::name('user')->delete(true);

    if ($delRes > 0) {
      return 'delete成功';
    } else {
      return 'delete失败';
    }
  }

  // 比较查询
  public function compareQuery()
  {
    // 查询表达式支持大部分常用的SQL语句
    // where('字段名','表达式','查询条件')
    // $queryList = Db::name('user')->where('id', 311)->find();
    // $queryList = Db::name('user')->where('id', '=', 311)->find();
    // <>、>、>=、<、<=
    $queryList = Db::name('user')->where('id', '<>', 311)->find();

    return json($queryList);
  }

  // 区间查询
  public function rangeQuery()
  {
    // 使用like表达式进行模糊查询
    // $queryList = Db::name('user')->where('username', 'like', '张三%')->select();
    // like表达式还可以支持数组传递进行模糊查询
    // $queryList = Db::name('user')->where('username', 'like', ['李%', '张三%'], 'or')->select();

    // like表达式具有两个快捷方式 whereLike 和 whereNotLike
    // $queryList = Db::name('user')->whereLike('username', '张三%')->select();
    // $queryList = Db::name('user')->whereNotLike('username', '张三%')->select();

    // between表达式具有两个快捷方式 whereBetween 和 whereNotBetween
    // $queryList = Db::name('user')->where('id', 'between', '19,25')->select();
    // $queryList = Db::name('user')->where('id', 'between', [19, 25])->select();
    // $queryList = Db::name('user')->whereBetween('id', [19, 25])->select();

    $queryList = Db::name('user')->whereNotBetween('id', '19,25')->select();



    return json($queryList);
  }

  // in具体查询
  public function inQuery()
  {
    // $queryList = Db::name('user')->where('id', 'in', '24,26,76')->select();
    // $queryList = Db::name('user')->where('id', 'in', [24, 26, 76])->select();

    // $queryList = Db::name('user')->whereIn('id',  [24, 26, 76])->select();
    $queryList = Db::name('user')->whereNotIn('id',  [24, 26, 76])->select();


    return json($queryList);
  }

  // exp查询 可以自定义字段后的SQL语句
  public function expQuery()
  {
    // $queryList = Db::name('user')->where('id', 'exp', 'IN (24,26,76)')->select();
    $queryList = Db::name('user')->whereExp('id', 'IN (24,26,76)')->select();

    return json($queryList);
  }

  // 时间查询 传统、快捷、固定、其他
  public function timeQuery()
  {
    // 传统方式
    // 可以使用 >、>=、<、<= 来筛选匹配的时间数据
    // $queryList = Db::name('user')->where('create_time', '>', '2018-1-1')->select();
    // 可以使用 between 来筛选匹配的时间数据
    $queryList = Db::name('user')->where('create_time', 'between', ['2018-1-1', '2019-1-1'])->select();

    // 快捷方式 whereTime/whereBetween/whereNotBetween、whereBetweenTime/whereNotBetweenTime
    // $queryList = Db::name('user')->whereTime('create_time', '>', '2018-1-1')->select();
    // $queryList = Db::name('user')->whereBetween('create_time', ['2018-1-1', '2019-1-4'])->select();
    // $queryList = Db::name('user')->whereBetweenTime('create_time', '2018-1-1', '2019-1-4')->select();

    // 固定查询
    // 使用whereYear查询今年的数据、去年的数据、某一年的数据
    // $queryList = Db::name('user')->whereYear('create_time')->select();
    // $queryList = Db::name('user')->whereYear('create_time', 'last year')->select();
    // $queryList = Db::name('user')->whereYear('create_time', '2019')->select();
    // 使用whereMonth查询当月数据，上月数据、某一月数据
    // $queryList = Db::name('user')->whereMonth('create_time')->select();
    // $queryList = Db::name('user')->whereMonth('create_time', 'last month')->select();
    // $queryList = Db::name('user')->whereMonth('create_time', '2019-10')->select();
    // 使用whereDay查询当天数据、昨天数据、某一天数据
    // $queryList = Db::name('user')->whereDay('create_time')->select();
    // $queryList = Db::name('user')->whereDay('create_time','last day')->select();
    // $queryList = Db::name('user')->whereDay('create_time', '2019-10-1')->select();

    // 其他查询
    // 查询指定时间额度数据，比如两个小时内的
    // $queryList = Db::name('user')->whereTime('create_time', '2 hours')->select();
    // 查询两个时间字段有效期的数据，比如会员开始到结束的期间
    // $queryList = Db::name('user')->whereBetweenTimeField('create_time', 'end_time')->select();



    return json($queryList);
  }

  // 聚合查询
  public function polymerizationQuery()
  {
    // 使用 count 方法，可以求出所查询数据的数量
    // $queryRes = Db::name('user')->count();
    // $queryRes = Db::name('user')->count('uid');

    // 使用 max 方法，可以求出所查询数据的最大值 第二个参数强制转化数字默认true
    // $queryRes = Db::name('user')->max('price');

    // 使用 min 方法，可以求出所查询数据的最小值 也可以强制转化为数字
    // $queryRes = Db::name('user')->min('price');

    // 使用 avg 方法，可以求出所查询数据的平均值
    // $queryRes = Db::name('user')->avg('price');

    // 使用 sum 方法，可以求出所查询数据的总和
    $queryRes = Db::name('user')->sum('price');



    return json($queryRes);
  }

  // 子查询
  public function subQuery()
  {
    // 使用 fetchSql 方法，可以设置不执行Sql,而是返回SQL语句
    // $queryRes = Db::name('user')->fetchSql(true)->select();

    // 使用 buildSql 方法, 也是返回 SQL 语句，不需要再执行 select，且有括号
    // $queryRes = Db::name('user')->where('id', 27)->buildSql();

    // 实现子查询
    // 求出所有男的uid
    // $subQuery = Db::name('two')->field('uid')->where('gender', '男')->buildSql(true);
    // $queryRes = Db::name('one')->where('id', 'exp', 'IN' . $subQuery)->select();

    // 使用闭包的方法实现
    $queryRes = Db::name('one')->where('id', 'in', function ($query) {
      $query->name('two')->field('uid')->where('gender', '男');
    })->select();

    // 原生查询 quert execute
    // $queryRes = Db::query('select * from tp_user');

    // return Db::getLastSql();

    return json($queryRes);
  }

  // 链式查询
  public function chainQuery()
  {
    // where 条件
    // 表达式查询 常用
    $queryRes = Db::name('user')->where('id', '>', 30)->select();
    // 关联数组查询，通过键值对进行匹配查询
    $queryRes = Db::name('user')->where([
      'gender'   =>  '男',
      'price'    =>  '100'
    ])->select();
    // 索引数组查询，通过数组里的数组拼接方式查询
    $queryRes = Db::name('user')->where([
      ['gender', '=', '男'],
      ['price', '=', '100']
    ])->select();
    // 复杂数组组装后，通过变量传递，增加可读性
    $map[] = ['gender', '=', '男'];
    $map[] = ['price', '=', '100'];
    // halt($map);
    $queryRes = Db::name('user')->where($map)->select();
    // 字符串传值，简单粗暴的查询方式
    $queryRes = Db::name('user')->where('gender="男" AND price IN (60,70,100)')->select();
    // 如果SQL查询采用了预处理，也能支持
    $queryRes = Db::name('user')->whereRaw('id=:id', ['id' => 27])->select();


    // field 条件
    // 使用 field方法，可以指定要查询的字段
    $queryRes = Db::name('user')->field('id, username, email')->select();
    $queryRes = Db::name('user')->field(['id', 'username', 'email'])->select();
    // 使用 field 方法，给指定的字段设置别名
    $queryRes = Db::name('user')->field('id,username as name')->select();
    $queryRes = Db::name('user')->field(['id', 'username' => 'name'])->select();
    // 使用 fieldRaw 方法，可以直接给字段设置 MySQL 函数
    // $queryRes = Db::name('user')->fieldRaw('id,SUM(price)')->select();
    // 使用 field(true)布尔参数,可以显示显示所有字段
    $queryRes = Db::name('user')->field(true)->select();
    // 使用 withoutField 方法可以将某些字段排除，屏蔽
    $queryRes = Db::name('user')->withoutField('id')->select();
    // 使用 field 方法在新增时，可以校验字段的合法性
    // $queryRes = Db::name('user')->field('username,email')->insert($data);



    // alias 
    // 使用 alias 方法可以给数据库起一个别名
    $queryRes = Db::name('user')->alias('a')->select();


    return json($queryRes);
  }

  // 链式查询 更多
  public function chainMoreQuery()
  {
    // limit 限制返回条数
    // 使用 limit 方法，限制获取输出数据的个数
    $queryRes = Db::name('user')->limit(5)->select();
    // 分页模式，即需要传递两个餐宿，比如从第三条开始显示5条
    $queryRes = Db::name('user')->limit(2, 5)->select();
    // 实现分页,需要严格计算每页显示的条数，然后从第几条开始
    $queryRes = Db::name('user')->limit(5, 5)->select();


    // page
    // 使用 page 函数分页方法，优化了 limit 方法，无需计算分页条数
    // 第一页
    $queryRes = Db::name('user')->page(1, 5)->select();


    // order
    // 使用 order 方法，可以指定排序方法,没有指定第二参数则默认为 asc
    $queryRes = Db::name('user')->order('id', 'desc')->select();
    // 支持数组的方式，对多个字段进行排序
    $queryRes = Db::name('user')->order(['id' => 'desc', 'create_time' => 'desc'])->select();
    // 使用 orderRaw 方法，可以直接给排序字段设置 MySQL 函数
    $queryRes = Db::name('user')->orderRaw('FIELD(username,"孙悟饭") DESC')->select();



    // group
    // 使用 group 方法，给性别不同的人进行 price 字段的综合统计
    $queryRes = Db::name('user')->fieldRaw('gender,SUM(price) as total')->group('gender')->select();
    // 也可以进行多字段分组统计
    $queryRes = Db::name('user')->fieldRaw('gender,password,SUM(price) as total')->group('gender,password')->select();



    // having
    // 使用 group 的分组后，可以再使用 having 进行筛选
    $queryRes = Db::name('user')->fieldRaw('gender,SUM(price) as total')
      ->group('gender')
      ->having('total > 720')
      ->select();


    return json($queryRes);
  }


  // 高级查询
  public function advancedQuery()
  {

    // OR| AND& 实现 where 条件的高级查询，where 支持多个连缀
    $queryRes = Db::name('user')
      ->where('username|email', 'like', '%悟%')
      ->where('price&id', '>', 20)
      ->select();


    // 关联数组方式，可以再 where 进行多个字段查询
    $queryRes = Db::name('user')->where([
      ['id', '>', 20],
      ['status', '=', 1],
      ['price', '>=', 70],
      ['email', 'like', '%163%']
    ])->select();


    // 条件字符串复杂组装，使用 exp，就可以使用 raw 方法
    $queryRes = Db::name('user')->where([
      ['status', '=', 1],
      ['price', 'exp', Db::raw('>70')],
    ])->select();


    // 如果有多个 where, 并且是分离的 map,而 map本身有多个条件 [] 一个整体
    $map = [
      ['id', '>', 20],
      ['email', 'like', '%163%'],
      ['price', 'exp', Db::raw('>70')]
    ];
    $queryRes = Db::name('user')->where([$map])->where('status', 1)->select();


    // 如果条件中有多次出现一个字段，并且需要 OR 来左右筛选，可以使用 whereOr
    $map1 = [
      ['email', 'like', '%163%'],
      ['price', 'exp', Db::raw('>70')]
    ];
    $map2 = [
      ['email', 'like', '%qq%'],
      ['price', 'exp', Db::raw('>90')]
    ];
    $queryRes = Db::name('user')->whereOr([$map1, $map2])->select();


    // 对于比较复杂或者不知道如何拼装 SQL 条件，则直接使用 whereRaw
    $queryRes = Db::name('user')->whereRaw('(username LIKE "%悟%" AND email LIKE "%163%") OR (price > 70)')->select();


    // return Db::getLastSql();

    return json($queryRes);
  }
}
