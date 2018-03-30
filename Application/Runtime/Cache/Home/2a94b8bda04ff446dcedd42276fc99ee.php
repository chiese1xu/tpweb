<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme.css" />
	<style>
	#container{
		margin:0 auto;
		width:40%;
		height:400px;
	}
	</style>
</head>

<body>
	index
</body>
	<form action="/index.php/Home/Index/postnews" method="post">
		<script id="container" name="content" type="text/plain">
			这里写你的初始化内容
		</script>
		<input type="submit">
	</form>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/Public/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/Public/ueditor/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
		window.UEDITOR_HOME_URL ='/Public/upload/'
    </script>	
</html>