# MoeCDN for Typecho

这是原[MoeCDN-Typecho](https://github.com/MoeNetwork/MoeCDN-Typecho)插件重制版

让MoeCDN来加速Typecho内置的Google APIs和Gravatar头像服务。

## 感谢原作者

此项目修改于 MoeNetwork/MoeCDN-Typecho ，由于插件被原作者弃用，因此修复后继续提供服务。

### 免费 Gravatar 头像加速

因为中国大陆的网络特殊性，Typecho内置的Gravatar头像服务往往会出现超时或无法连接问题。使用 MoeCDN 可显著加速头像加载速度。

### 免费 Google APIs 加速

使用谷歌公共库可以加快网页加载速度，除fonts以外大部分都无法在中国大陆正常访问。启用此插件后，将会替换原接口为 MoeCDN 源以正常访问 Google APIs

## 现在就去下载吧~

下载压缩包后，解压并修改解压出来的文件夹名字为“MoeCDN”，上传到 Your Typecho/usr/plugins/ 目录下，到后台启用插件即可。

## 关于启用插件提示 500 的说明

  1. 发生此原因的时候，百分之九十九的情况下删除插件文件夹 ./usr/plugins/MoeCDN-for-Typecho-master 文件名中的 "-Typecho-master"，仅保留“MoeCDN”或其他名字即可。
  2. 如果无法解决问题，请在 config.inc.php 中 加入 ```define("__TYPECHO_DEBUG__",true);``` ，然后复制错误信息到 GitHub issues 页面提问。

## 其他

MoeCDN for Typecho 插件的诞生离不开 [@MoeNetwork](https://github.com/MoeNetwork) 对 MoeCDN 项目的建设以及 [@kokororin](https://github.com/kokororin) 对插件代码的修改优化。感谢前人种树，我们才得以推出此插件
如有问题请联系我们👉 https://t.me/idcblog
