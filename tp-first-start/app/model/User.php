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

  // 模型开启自动时间戳
  // protected $autoWriteTimestamp = true;
  protected $autoWriteTimestamp = 'datetime'; // 日期时间格式

  // 只读字段，修改时无法修改
  // protected $readonly = ['username', 'email'];

  // 模型类型转化
  // protected $type = [
  //   'price'    =>  'integer'
  // ];

  // 废弃字段
  // protected $disuse = ['create_time', 'update_time'];

  // 设置 json 字段
  protected $json = ['list'];

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

  // 模型查询范围 前缀为 scope
  // 在模型端创建一个封装的查询或写入方法，方便控制器端调用
  public function scopeMale($query)
  {
    $query->where('gender', '男')->field('id,username,email')->limit(5);
  }

  // 模型查询范围 带参数
  public function scopeEmail($query, $value)
  {
    $query->where('email', 'like', '%' . $value . '%');
  }

  public function scopePrice($query, $value)
  {
    $query->where('price', '>', $value);
  }

  // 模型搜索器
  // 搜索器是用于封装字段（或搜索标识）的查询表达式，类似查询范围
  // 一个搜索器对应模型的一个特殊方法，该方法为 public
  // 方法的命名规范为 searchFieldAttr
  public function searchEmailAttr($query, $value)
  {
    $query->where('email', 'like', $value . '%');
  }

  public function searchCreateTimeAttr($query, $value, $data)
  {
    $query->whereBetweenTime('create_time', $value[0], $value[1]);
    // 第三个参数则是传递的所有值
    if (isset($data['sort'])) {
      $query->order($data['sort']);
    }
  }
}
