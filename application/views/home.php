<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>全栈之路</title>
<link rel="stylesheet" href="recourse/css/bootstrap.css">
<link rel="stylesheet" href="recourse/css/custom.css">
</head>

<body>

<div class="container" align="center">
	<h1 margin>新浪微博PHP SDK由新浪SAE团队开发和维护</h1>
	<h2>本DEMO演示了PHP SDK的授权及接口调用方法，开发者可以在此基础上进行灵活多样的应用开发。</h2>

	<!-- 授权按钮 -->
    <p><a href="<?=$code_url?>"><button type="button" class="btn btn-danger btn-lg">点击授权</button></a></p>
</div>
<div>
</div>
</body>
</html>