<?php

namespace app\controller;

use app\BaseController;
use think\facade\Log;

class LogTest extends BaseController
{

  public function index()
  {
    // 手动写日志
    Log::record('记录日志', 'info');
    // 日志级别 从低到高
    // debug, info, notice, warning, error, critical, alert, emergency

    // 错误信息
    Log::record('错误信息', 'error');

    // 关闭写入
    // Log::close();

    // 系统发生异常时会自动写入日志 try/catch 需要手动处理
  }
}
