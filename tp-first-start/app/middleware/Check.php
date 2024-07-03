<?php

declare(strict_types=1);

namespace app\middleware;

class Check
{
  /**
   * 处理请求
   *
   * @param \think\Request $request
   * @param \Closure       $next
   * @return Response
   */
  public function handle($request, \Closure $next)
  {
    // url上有参数时重定向 中间件处理
    if ($request->param('name') === 'index') {
      return redirect('../');
    }

    // 中间件必须返回
    return $next($request);
  }

  // 执行收尾工作 最后执行
  public function end()
  {
    // 中间件最后执行
  }
}
