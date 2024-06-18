<?php

namespace app\controller;

class Test
{
  public function index()
  {
    return 'hello,ThinkPHP6';
  }

  public function hello($value = '张三')
  {
    return 'hello 方法' . $value;
  }
}
