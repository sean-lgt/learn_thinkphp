<?php

namespace app\controller;

use app\BaseController;
use think\facade\View;

use app\model\User;

class ViewTemplate extends BaseController
{

  // 定义变量
  public $name = 'sean';
  public $age = '18';
  // 定义常量
  const PI = 3.14;

  public function index()
  {

    // 不使用模板引擎 直接 require 引入文件
    // require 'view/index.html';

    // 使用模板引擎的调用写法，需要先安装驱动
    // composer require topthink/think-view
    // return View::fetch('index');

    // 传递变量 使用 view 助手函数也可以
    // View::assign('name', 'sean');
    View::assign([
      'name'   => 'sean',
      'age'    => '18'
    ]);

    return View::fetch('index');
  }

  public function indexConfig()
  {
    // 可以动态修改模板的配置
    // View::config([
    //   'view_dir_name' => 'view2'
    // ]);
    // return View::fetch('index');

    // 调用其他控制器下的模板
    return View::fetch('address/index');
    // 如果是多模块（多应用） 也可以实现跨模块调用
    // return View::fetch('admin@user/index');
    // 如果想调用 public 公共目录的模板文件，则直接用 ../public 后面跟着 URL 就行了
    // return View::fetch('../public/index')

  }

  public function outputIndex()
  {

    // 数组传递
    $dataArr = [
      'key'    =>  13,
      'value'  =>  '测试'
    ];

    // 常量


    View::assign([
      'name'   => 'sean',
      'age'    => '18',
      'data'   => $dataArr,
      'password' => 123456,
      'time'   => time(),
      'obj'    => $this
    ]);

    return View::fetch('index');
  }

  public function tempFn()
  {
    return 'temp 方法';
  }

  public function outputIndex2()
  {

    // 数组传递
    $dataArr = [
      'key'    =>  13,
      'value'  =>  '测试'
    ];

    // 获取数据
    $userList = User::select();


    View::assign([
      'name'   => 'sean',
      'age'    => '18',
      'data'   => $dataArr,
      'password' => 123456,
      'time'   => time(),
      'obj'    => $this,
      'userList' => $userList,
    ]);

    return View::fetch('index2');
  }
}
