<?php
// 全局中间件定义文件
return [
  // 全局请求缓存
  // \think\middleware\CheckRequestCache::class,
  // 多语言加载
  \think\middleware\LoadLangPack::class,
  // Session初始化
  \think\middleware\SessionInit::class,

  // 注册自定义中间件
  \app\middleware\Check::class,
  \app\middleware\Auth::class
];
