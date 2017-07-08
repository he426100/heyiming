<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hello, heyiming</title>
        <link rel="stylesheet" href="/layui/css/layui.css">
    </head>
    <body>
    	<ul class="layui-nav" lay-filter="">
		  <li class="layui-nav-item"><?php echo $hello;?>，<?php echo $user->user_name;?></li>
		</ul>
        <script src="/layui/layui.js"></script>
        <script>
		layui.config({
		  base: '/js/' //你的模块目录
		}).use('index'); //加载入口
		</script>
    </body>
</html>
