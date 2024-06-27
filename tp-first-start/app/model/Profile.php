<?php

namespace app\model;

use think\Model;


class Profile extends Model
{
  // 反向关联
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
