<?php
session_start();
include_once('config.php');
include_once('saetv2.ex.class.php');
$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken('code', $keys) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$c = new SaeTClientV2(WB_AKEY,WB_SKEY,$token['access_token']);
	$user = $c->show_user_by_id($token['uid']);
	$mysql = new SaeMysql();
	$sql = "INSERT INTO `user_count`(`uid`, `sex`, `follow_count`, `weibo_count`, `name`,`token`) VALUES({$user['id']}, '{$user['gender']}',{$user['followers_count']},{$user['statuses_count']},'{$user['name']}','{$token['access_token']}')";
	$mysql-> runSql( $sql );
	
	if ( $mysql->errno() !=0)
	{
		die( "Error:".$mysql->errmsg() );
	}
	$mysql->closeDb();
	$_SESSION['token'] = $token;
	// setcookie('weibojs_'.$o->client_id, http_build_query($token));
	header("Location:analysis.php");
?>

<?php
} else {
?>
授权失败。
<?php
}
?>
