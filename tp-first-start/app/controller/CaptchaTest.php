<?php

namespace app\controller;

use app\BaseController;
use think\facade\Validate;
use think\facade\View;

class CaptchaTest extends BaseController
{

  public function index()
  {
    // return View::fetch('captcha');
    return View::fetch('check');
  }

  public function check()
  {
    //验证码验证规则
    $validate = Validate::rule([
      'captcha' => 'require|captcha'
    ]);
    //验证码和表单对比
    $result = $validate->check([
      'captcha' => input('post.code')
    ]);
    if (!$result) {
      dump($validate->getError());
    } else {
      dump('验证通过');
    }
  }
}
