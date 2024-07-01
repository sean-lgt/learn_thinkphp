<?php

namespace app\controller;

use app\BaseController;

use app\model\User;



class DependInject extends BaseController
{
  // 依赖注入本质上是对嘞的依赖通过构造器完成自动注入
  // 在控制器构造方法和操作方法中一旦对参数进行对象类型约束会自动触发依赖注入

  protected $userModel;

  // 自动依赖注入 new 自动绑定自动实例化
  public function __construct(User $userModel)
  {
    $this->userModel = $userModel;
  }

  // 使用依赖注入中的数据
  public function index()
  {
    return $this->userModel->dependInjectList;
  }
}
