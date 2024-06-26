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
}
