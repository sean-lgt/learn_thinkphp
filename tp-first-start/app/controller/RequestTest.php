<?php

namespace app\controller;

use app\BaseController;
use think\Facade;
use think\Request;
// 通过门面模式
use think\facade\Request as FacadeRequest;

class RequestTest extends BaseController
{

  // 依赖注入的方式
  protected $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function index()
  {
    // php 原生方式获取 url 参数
    // $getParams = $_GET['id'];

    // 使用 Request 方式获取
    // $getParams = $this->request->param('id');

    // 通过门面模式获取参数
    // $getParams = FacadeRequest::param('id');

    // 使用助手函数获取 无需其他引用
    $getParams = request()->param('id');

    return json($getParams);
  }

  public function reqInfo()
  {
    $data['url'] = FacadeRequest::url();
    $data['baseFile'] = FacadeRequest::baseFile();
    $data['root'] = FacadeRequest::root(true);
    $data['controller'] = FacadeRequest::controller();
    $data['action'] = FacadeRequest::action();

    return json($data);
  }

  // 请求变量
  public function requestVarParams()
  {
    // 判断参数是否存在 第二个参数为请求参数方式
    $data['has'] = FacadeRequest::has('id', 'get');
    // 获取参数值 自动转义 路由参数也可以获取
    $data['param'] = FacadeRequest::param('id');
    $data['allParam'] = FacadeRequest::param();
    // 获取 $_GET 变量
    $data['$_GET'] = FacadeRequest::get('id');

    // 获取 session 变量
    // $data['session'] = FacadeRequest::session();

    // 获取 cookie 变量
    $data['cookie'] = FacadeRequest::cookie();

    // 获取 $_SERVER 变量
    // $data['$_SERVER'] = FacadeRequest::server();
    // 获取中间件传递的变量
    // $data['middleware'] = FacadeRequest::middleware();
    // 获取 $_FILES 变量
    // $data['$_FILES'] = FacadeRequest::file();

    // 使用 only 可以获取指定变量，也可以设置默认值 第二参数是设置请求方式
    $data['only'] = FacadeRequest::only(['only' => 1]);

    // 使用变量修饰符，可以镜像强制参数类型转换
    // /s 字符串  /d 整数  /b 布尔  /a 数组  /f 浮点
    $data['$int'] = FacadeRequest::param('intId/d');


    return json($data);
  }

  // 助手函数，简化操作 常用
  public function requestCommonParams()
  {
    // 判断参数是否存在
    $data['has'] = input('?get.id');
    // 获取参数值
    $data['id'] = input('get.id');
    // 设置默认值
    $data['type'] = input('get.type', '1');
    // 过滤器
    $data['html'] = input('get.name', '', 'htmlspecialchars');
    // 强制类型转化 /s 字符串  /d 整数  /b 布尔  /a 数组  /f 浮点
    $data['intId'] = input('get.intId/d');


    return json($data);
  }

  // 请求类型
  public function requestMethod()
  {
    // 判断是否为 get 请求
    $data['isGet'] = FacadeRequest::isGet();
    // 判断是否为 post 请求
    $data['isPost'] = FacadeRequest::isPost();
    // 获取当前请求的类型
    $data['method'] = FacadeRequest::method();
    // 获取HTTP请求头信息
    $data['header'] = FacadeRequest::header();


    return json($data);
  }
}
