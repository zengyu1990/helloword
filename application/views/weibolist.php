<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$mb	 = $c->send_comment('3666726686702249','我操');

$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
$mysqli = mysqli_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS, SAE_MYSQL_DB, SAE_MYSQL_PORT);
$sql = "INSERT INTO  `app_zeny`.`time` (`visittimes`)VALUES (NULL)";
$mysqli->query($sql);
$result = $mysqli->query('select * from time ORDER BY `visittimes`  DESC LIMIT 1');
print_r ($_SESSION);
exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>全栈之路</title>
<link rel="stylesheet" href="/recourse/css/bootstrap.css">
<link rel="stylesheet" href="/recourse/css/custom.css">
</head>
<body>
<div class="container" align="center">
	<h1><?=$user_message['screen_name']?>,您好！ 欢迎来到Weibo Killer</h1>
</div>

<div style="padding:15px;margin:5px;border:2px solid #ccc">
	<?php 
		$ma = $c->friends_by_id($uid);
		foreach( $ma['users'] as $item ) {
		$md  = $c->unfollow_by_id($item['id']); 
		print_r ($md);
		echo '</br>';
		}
	?>	
</div>
</body>
</html>