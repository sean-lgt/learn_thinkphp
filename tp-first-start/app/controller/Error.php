<?php

namespace app\controller;

use app\BaseController;

class Error extends BaseController
{
  public function index()
  {
    // 返回实际路径
    return "当前控制器不存在";
  }
}
