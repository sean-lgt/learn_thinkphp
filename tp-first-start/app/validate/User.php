<?php

declare(strict_types=1);

namespace app\validate;

use think\Validate;

class User extends Validate
{
  /**
   * 定义验证规则
   * 格式：'字段名' =>  ['规则1','规则2'...]
   *
   * @var array
   */
  protected $rule = [
    'username' => 'require|max:25|customCheckName:测试', //不得为空，并且不得超过25
    'email'    => 'email', // 邮箱格式要正确
  ];

  /**
   * 定义错误信息
   * 格式：'字段名.规则名' =>  '错误信息'
   *
   * @var array
   */
  protected $message = [
    'username.require'       => '用户名不为空',
    'username.max'           => '用户名不得超过25位',
    'email'                  => '邮箱格式错误'
  ];

  // 场景验证
  protected $scene = [
    'insert'   =>  ['username', 'email'],  // 新增
    'edit'     =>  ['username'],  // 编辑
  ];

  // 自定义规则
  protected function customCheckName($value, $rule, $data, $field, $title)
  {
    return $value !== $rule ? true : '非法错误';
  }
}
