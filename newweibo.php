<?php
	session_start();
	include_once('saetv2.ex.class.php');
	$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	$my_message = $c->show_user_by_id($uid);
	if(!$uid) {
		header("Location:index.php");
	}
?>