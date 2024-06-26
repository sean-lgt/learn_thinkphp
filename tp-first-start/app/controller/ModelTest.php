<?php

namespace app\controller;

use app\BaseController;
use app\model\User;
use think\facade\Db;


class ModelTest extends BaseController
{
  public function index()
  {
    $queryRes = User::select();

    return json($queryRes);
  }

  public function getUserInfo()
  {
    $queryRes = User::find(27);

    return json($queryRes);
  }
}
