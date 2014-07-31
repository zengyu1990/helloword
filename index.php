<?php
	session_start();
    include_once('config.php');
	include_once('saetv2.ex.class.php');
	$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
	$code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="icon" href="resources/images/icon.png" type="image/x-icon"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="resources/style.css" type="text/css" media="screen"/>
		<script src="resources/jquery-1.11.0.min.js" type="text/javascript"></script>
		<script type="text/javascript">get_ip_json(<?php echo WB_AKEY?>);</script>
		<title>微博价值</title>
	</head>
	<body class="page_home">
		<?php //@include_once('http://www.meiriq.com/sina/pubhtml/header.html'); ?>
		<div class="main">
			<div class="body_bg_index">
				<div class="index_img"></div>
				<a href="<?=$code_url?>" id="subm" onclick="openwin()" title="点击进入！"><div class="index_buttom"></div></a>
			</div>
			<div class="right_body">
				<div style="height:225px;">
				<iframe src="http://mrqams.sinaapp.com/call.php?ad_id=<?php echo ISBN_ID; ?>&ad_type_id=16&uid=0" height="220px" width="185px" scrolling="no" style="border:0;" allowtransparency="true"></iframe>
				</div>
				<div class="line"></div>
				<div class="app_nav">
					<div class="common">
						<div class="hot">热门应用排行榜</div>
					</div>
					<div class="hot_list">
						<div class="orderOne">1</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-2-91" target="_blank">假如你参加中国好声音</a>
						<div class="orderOne">2</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-2-93" target="_blank">你是哪位才子才女？</a><div class="updown"></div>
						<div class="orderOne">3</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-7-7" target="_blank">好友上辈子与你的缘分</a><div class="updown"></div>
						<div class="orderTwo">4</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-300-11" target="_blank">你的最佳损友是谁？</a><div class="updown" style="background-position:0 -11px;"></div>
						<div class="orderTwo">5</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-301-7" target="_blank">好友夫妻相</a><div class="updown" style="background-position:0 -11px;"></div>
						<div class="orderTwo">6</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-2-94" target="_blank">你的人生导师会是谁？</a>
						<div class="orderTwo">7</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-2-95" target="_blank">月饼口味大战</a>
						<div class="orderTwo">8</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-5-30" target="_blank">12星座爱情致命缺点</a><div class="updown"></div>
						<div class="orderTwo">9</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-7-11" target="_blank">适合一起疯的活动</a>
						<div class="orderTwo">10</div><a href="http://17.xingzuopeiou.sinaapp.com/counter.php?app=1-301-17" target="_blank">钓鱼岛知识测试</a>		
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
			document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F124a412bdc688f7e376be44d993597d4' type='text/javascript'%3E%3C/script%3E"));
		</script>
	</body>
</html>