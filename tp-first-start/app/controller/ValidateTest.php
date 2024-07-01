<?php

namespace app\controller;

use app\BaseController;
use app\validate\User as UserValidate;
use think\facade\Validate;
use think\exception\ValidateException;

class ValidateTest extends BaseController
{

  // 验证器的使用
  // 命令生成想要的类
  // php think make:validate User

  public function index()
  {

    try {
      validate(UserValidate::class)->check([
        'username'   =>  '测试',
        'email'      =>  '1231@163.com'
      ]);
      return '验证通过';
    } catch (ValidateException $e) {
      return $e->getError();
    }
  }

  // 自定义验证 独立
  public function checkRule()
  {
    $validate = Validate::rule([
      'username' => 'require|max:25|customCheckName:测试', //不得为空，并且不得超过25
      'email'    => 'email', // 邮箱格式要正确
    ]);

    $validate->message([
      'username.require'       => '用户名不为空',
      'username.max'           => '用户名不得超过25位',
      'email'                  => '邮箱格式错误'
    ]);

    $result = $validate->check([
      'username'   =>  '',
      'email'      =>  '1231@163.com'
    ]);

    if (!$result) {
      return '验证失败 ' . $validate->getError();
    } else {
      return '验证通过';
    }
  }
}
