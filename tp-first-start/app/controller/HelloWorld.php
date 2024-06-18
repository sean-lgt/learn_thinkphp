<?php

namespace app\controller;

class HelloWorld
{
  public function index()
  {
    return 'hello,helloworld';
  }

  public function arrayOutPut()
  {
    // json对象用数组形式显示
    $data = ['a' => 1, 'b' => 2, 'c' => 3];

    halt('中断输出', $data);

    // 返回json对象
    return json($data);
  }
}
