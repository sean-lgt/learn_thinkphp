<?php

namespace app\controller;

use app\BaseController;



class RouterTest extends BaseController
{
  public function index()
  {
    return 'hello world!!';
  }

  public function details($id)
  {
    return '详情' . $id;
  }
}
