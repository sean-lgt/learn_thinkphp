<?php

namespace app\controller;

use app\BaseController;
use think\facade\Lang;

class LangTest extends BaseController
{

  public function index()
  {
    // 系统会默认指定 zh-cn 这个语言包，可以通过 ::get 获取输出
    // ?lang=en-us 系统自动切换并且存入 cookie
    $name = Lang::get('require_name');
    $loginName = Lang::get('user.login');
    return json([
      'name'       => $name,
      'loginName'  => $loginName
    ]);
  }
}
