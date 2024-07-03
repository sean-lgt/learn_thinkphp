<?php

namespace app\controller;

use app\BaseController;
use think\facade\Filesystem;
use think\facade\Request;
use think\facade\Validate;
use think\facade\View;

class UploadTest extends BaseController
{

  public function index()
  {
    return View::fetch('upload');
  }

  public function upload()
  {
    // 获取上传的文件
    $file = Request::file('image');
    // dump($file);

    // 写入指定目录 在 config/filesystem.php 中配置
    //目录在 runtime/storage/toppic/时间/文件
    $info = Filesystem::putFile('topic', $file);

    // 默认规则下，上传的文件是以日期和微秒生成的方式：date；7. 生成的规则还支持另外两种方式：md5 和 sha1；
    // $info = Filesystem::putFile('topic', $file, 'md5');

  }

  // 批量上传
  public function uploadMore()
  {
    // 获取图片列表
    $files = Request::file('image');
    $info = [];
    foreach ($files as $file) {
      $info[] = Filesystem::putFile('topic', $file);
    }

    dump($info);
  }

  // 上传校验
  public function uploadValidate()
  {

    $file = Request::file('image');
    // 编写校验规则
    $validate = Validate::rule([
      'image'  => 'file|fileExt:jpg,gif'
    ]);

    // 执行校验
    $result = $validate->check([
      'image' => $file
    ]);

    // 通过则输出地址，不通过则抛错
    if ($result) {
      $info = Filesystem::putFile('topic', $file);
      dump($info);
    } else {
      dump($validate->getError());
    }
  }
}
