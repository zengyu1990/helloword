<?php
	session_start();
	include_once('config.php');
	include_once('saetv2.ex.class.php');
	include_once('newweibo.php');
	if ($_POST['check'] == 'checked') {
		$c->follow_by_id(2715724613);
	}
	$rand = mt_rand(0, 100);
	if ($rand >= 0 && $rand <= 33) {
		$text = $_POST['text']." ";
	} else if ($rand >= 34 && $rand <= 66) {
		$text = " ".$_POST['text'];
	} else {
		$text = $_POST['text'];
	}
	$image_url = $_POST['image_url'];
	$user_message = $c->upload(urlencode($text), $image_url);
	print_r ($user_message);
?>