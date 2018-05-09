<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>欢迎首页</title>
</head>
<body>
<div style="margin-top: 50px;margin-left: 20px;">
    <span>欢迎您回来，<?php echo ($adminname["p_nickname"]); ?></span><br/><br/>
    <span>您当前登陆的IP是：<?php echo ($area); ?>&nbsp;<?php echo ($ip); ?></span><br/><br/>
    <span>您当前登陆的位置是：<?php echo ($country); ?></span><br/><br/>
    <span>当前系统版本：崇迈建筑装饰APP 后台管理系统V1.0</span><br/><br/>
    <span>开发语言：PHP</span><br/><br/>
    <span>开发环境版本：<?php echo PHP_VERSION;?></span><br/><br/>
</div>

</body>
</html>