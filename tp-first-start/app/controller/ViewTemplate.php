<?php

namespace app\controller;

use app\BaseController;
use think\facade\View;

class ViewTemplate extends BaseController
{

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
}
