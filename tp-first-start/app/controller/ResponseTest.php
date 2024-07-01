<?php

namespace app\controller;

use app\BaseController;


class ResponseTest extends BaseController
{

  // 依赖注入的方式
  protected $request;



  public function index()
  {
    //  响应状态码
    // return json('126464')->code(201);

    // 重定向
    // return redirect('https://www.baidu.com');

    // 附加 session 信息
    return json('123456session');
  }
}
