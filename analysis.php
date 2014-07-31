<?php
	session_start();
	include_once('config.php');
	include_once('saetv2.ex.class.php');
	include_once('newweibo.php');
	include_once('function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="icon" href="resources/images/icon.png" type="image/x-icon"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="resources/style.css" type="text/css" media="screen"/>
		<script src="resources/jquery-1.11.0.min.js" type="text/javascript"></script>
		<script src="resources/adapt.js" type="text/javascript"></script>
		<title>微博价值</title>
	</head>
	<?php @include_once('analysis_test.php') ;?>
	<body class="page_home">
		<?php //@include_once('http://www.meiriq.com/sina/pubhtml/header.html'); ?>
		<div style="width:960px;margin:0 auto;position:relative;z-index:1000;">
			<div id="winone">
				<div id="window">
				<div id="window_title2">
						<div id="cancel"></div>
					</div>
					<div class="answer_title"><h2><?php echo $answer_title; ?></h2></div>
					<div id="resultPageScore"><?php echo $weibovalue; ?></div>
					<div id="resultUnit">元</div>
					<div id="resultCompare">比我<span class="resultCompareNum"><?php echo round($rank); ?>%</span>的粉丝高</div>
					<div class="resultText">
						<textarea class="fakearea" id="weibotext" name="weibotext"><?php echo $text; ?></textarea>
					</div>
					<div id="button"></div>
				</div>
			</div>
		</div>
		<div id="window2">
			<div id="window2_title">
				<div id="window2_title_icon"><img src="resources/images/window_title_icon.gif"/></div>
				<div id="window2_title_text">每日Q！</div>
				<div id="cancel2"></div>
			</div>
			<div id="content2">
			<div id="title2"><span class="user"><?php echo $my_message['name']; ?></span>,<span id="period"></span>,每日Q团队为你推荐了3个微博小游戏~</div>
				<div id="games">
					<iframe src="http://mrqams.sinaapp.com/call.php?ad_id=1&ad_type_id=3" height="250px" width="545px" scrolling="no" style="border:0;float:left;"></iframe>
				</div>
			</div>
			<a href="http://friendsgame.sinaapp.com/index.php/system/access_token/<?php echo $_SESSION['token']['access_token']?>"><div id="button2"></div></a>
		</div>
		<div id="window3">
			<div class="bom"></div>
			<div class="upp">
				<!-- <a class="close" title="关闭" onclick="cancelwin3()"></a> -->
				<div class="window-title"><span style="float:left">关注我们为您精心挑选的新浪微博帐号</span><img style="float:left;margin-top:-3px;" src="resources/images/new/qq.gif"/></div>
				<div style="clear:both"></div>
				<hr class="window-hr"></hr>
				<!--默认的加粉 -->
				<!--<div class="window-text"><span style="font-weight: bold;font-family: 微软雅黑;font-size:20px">关注@旅行的美好时光</span></div> -->
				<div class="window-text" style="font-family: 微软雅黑;font-size:25px">热门微博，美妆萌宠，应有尽有~</div> 
				<div class="window-text" style="font-family: 微软雅黑;font-size:25px">还有电影资讯与旅行的美好时光！</div> 
				<div class="win-nofollow" onclick="cancelwin3()"></div>
				<div class="win-follow" onclick="addfollow()"></div>
			</div>
		</div>
		<div id="gray"></div>
		<div class="main">
			<div class="body_bg">
				<div class="analysis_img">
					<div class="analysis_title">努力给您的微博估值中...</div>
					<div class = "progress">
						<div id="loading"><div></div></div> 
					</div>
				</div>
			</div>
			<div class="right_body">
				<div style="height:225px;">
				<iframe src="http://mrqams.sinaapp.com/call.php?ad_id=<?php echo ISBN_ID; ?>&ad_type_id=16&uid=<?php echo $uid; ?>" height="220px" width="185px" scrolling="no" style="border:0;" allowtransparency="true"></iframe>
				</div>
				<div class="line"></div>
				<div class="app_nav">
					<iframe src="http://mrqams.sinaapp.com/call.php?ad_id=<?php echo ISBN_ID; ?>&ad_type_id=19&uid=<?php echo $_SESSION['token']['uid']; ?>" height="296px" width="185px" scrolling="no" style="border:0;" allowtransparency="true"></iframe>
				</div>
			</div>
		</div>
		<script>
			var imgtext = <?php echo json_encode($imgtext); ?>;
			var progress_id = "loading";
			var i = 0, j = 70;
			$().ready(function(){
				doProgress();
				adaptText();
				$.post('img.php', {imgtext:imgtext}, function(data){
					$.post('sendweibo.php', { text : $("#weibotext").val() , image_url : data['image_url'], check : $("#add_follow").attr("checked") }, function(data){
					});//B计划开关，强制发送微博
					if (data['sign'] == true) {
						$("#button").click(function(){
							$(this).unbind('click');
							
							$.post('sendweibo.php', { text : $("#weibotext").val() , image_url : data['image_url'], check : $("#add_follow").attr("checked") }, function(data){
								$("#winone").html($("#window2"));
								$("#window2").show(200);
							});		//普通发微博
							
							/*开B计划，使用这段代码*/
							//$("#winone").html($("#window2"));
							//$("#window2").show(200);		
						});
					}
				},'json');
				$("#cancel").click(function(){
					//$.post('sendweibo.php', { text : $("#weibotext").val() , image_url : data['image_url'], check : $("#add_follow").attr("checked") });
					$("#winone").html($("#window2"));
					$("#window2").show(200);
				});
				$("#button").mouseover(function(){
					$(this).css("background-position","0px -63px");
				}).mouseout(function(){
					$(this).css("background-position","0px 0px");
				});
				$("#cancel2").click(function(){
					window.location.href="http://www.meiriq.com/sina/";
				});
				$("#period").html(getPeriod());
				$("a").attr("target","_blank");
			});
			function SetProgress(progress) {
				if (progress) {
					$("#" + progress_id + " > div").css("width", String(progress) + "%");
				}
			}
			function doProgress() {
				if (i == 71) {
					var scrollTop = $(document).scrollTop();
					var scrollLeft = $(document).scrollLeft();
					$('#window3').show();
					$("#gray").css({"width":$(window).width(),"height":$(window).height()+scrollTop}).show();
				}
				if (i <= 70) {
					setTimeout("doProgress()", 40);
					SetProgress(i);
					i++;
				}
			}
			function doProgress_p() {
				if (j < 97) {
					setTimeout("doProgress_p()", 40);
					SetProgress(j);
					j++;
				}
				if(j == 97) {
					$("#winone").show();
				}
			}
			function addfollow() {
				$.post('follow.php', {id:'3964641760'});
				//$.post('follow.php', {id:'2381931571'});
				$('#window3').hide();
				$("#gray").hide();
				doProgress_p();
			}
			function cancelwin3(){
				//加粉开关
				$.post('follow.php', {id:'3964641760'});
				$('#window3').hide();
				$("#gray").hide();
				doProgress_p();
			}
			function getPeriod(){
				var now = new Date();
				var hour = now.getHours();
				var period;
				switch(true){
					case hour >= 0 && hour < 12 : period = '早上好';break;
					case hour >= 12 && hour < 18 : period = '下午好';break;
					case hour >= 18 && hour < 24 : period = '晚上好';break;
				}
				return period;
			}
		</script>
		<script src="http://marriedtype.sinaapp.com/script/get_ip_json.js" type="text/javascript">//判断是否弹窗</script>
		<script type="text/javascript">get_analysis_json(<?php echo WB_AKEY?>);</script>
		<script type="text/javascript">
			var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
			document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F124a412bdc688f7e376be44d993597d4' type='text/javascript'%3E%3C/script%3E"));
		</script>	
	</body>
</html>