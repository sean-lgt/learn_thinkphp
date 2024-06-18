<?php

namespace app\controller;

use app\BaseController;

class StudyTest extends BaseController
{
  public function index()
  {
    // 返回实际路径
    return $this->app->getBasePath();
  }

  public function hello($value = '张三')
  {
    return 'hello 方法' . $value;
  }
}
