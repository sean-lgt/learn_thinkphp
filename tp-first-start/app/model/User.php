<?php

namespace app\model;

use think\Model;

class User extends Model
{
  // 添加后缀需要设置模型名称
  protected $name = 'user';

  // 设置主键
  // protected $pk = 'uid';
  protected $pk = 'id';

  // 设置表
  protected $table = 'tp_user';

  // 初始化 构造方法
  protected static function init()
  {
    parent::init();
  }

  // 设置字段信息
  // protected $schema = [
  //   'id'          => 'int',
  //   'username'    => 'string',
  //   'password'    => 'string',
  //   'create_time' => 'int',
  //   'update_time' => 'int',
  // ];

  // 系统提供一条命令生成一个字段信息缓存 可以自动生成
  // php think optimize:schema

  // 是否严格区分大小写
  // protected $strict = false;

  // 模型的获取器
  // 获取器的作用是对模型实例的数据做出自动处理
  // 一个获取器对应模型的一个特殊方法，该方法为 public
  // 方法名规范为 getFieldAttr
  public function getStatusAttr($value)
  {
    $status = [
      -1  => '删除',
      0   => '禁用',
      1   => '正常',
      2   => '待审核',
    ];

    return $status[$value];
  }

  // 也可以自定义虚拟字段
  public function getNothingAttr($value, $data)
  {
    $myGet = [
      -1  => '删除',
      0   => '禁用',
      1   => '正常',
      2   => '待审核',
    ];
    return $myGet[$data['status']];
  }
}
