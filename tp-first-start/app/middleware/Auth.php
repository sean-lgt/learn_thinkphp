<?php

declare(strict_types=1);

namespace app\middleware;

class Auth
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
    // if($request->param('id') === 10){

    // }

    // 中间件必须返回
    return $next($request);
  }
}
