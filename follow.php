<?php
	
	session_start();
	include_once('config.php');
	include_once('saetv2.ex.class.php');
	include_once('newweibo.php');
	$id = $_POST['id'];
	$db = new saeMysql(); 
    $o = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
	function getUid(){
		$o = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
		$uid_get = $o->get_uid();
		$uid = $uid_get['uid'];
		return $uid;
    }
    function getUser(){
		$o = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
		$uid = getUid();
		$user = $o->show_user_by_id($uid);
		return $user;
	}
	if(isset($id)){
		$a1=$o->follow_by_id(3964641760);//旅行的美好时光 164083 目标4W
		$a2=$o->follow_by_id(3704195053);//好莱坞电影院 141013   目标4.5W
		//$a3=$o->follow_by_id(3273156024);//生活幽默大赏
		//$a4=$o->follow_by_id(3273040604);//萌宠小图库
		//$a5=$o->follow_by_id(3066837133);//美丽穿搭日志
		//美君新加了一个人进来
		//$a6=$o->follow_by_id(1704247582);//热门围脖风云榜 1199022  目标3W
		//$a7=$o->follow_by_id(3871307373);//全球安卓报道
		$a8=$o->follow_by_id(3632285715);//星座占卜术
		//$a9=$o->follow_by_id(3640272825);//新番日剧抢鲜看
		//$a10=$o->follow_by_id(2258904294);//画片贩卖社
		$a11=$o->follow_by_id(3650637801);//喵星人的喵星语
		//$a12=$o->follow_by_id(3437298064);//粤啱你心水
		//$a13=$o->follow_by_id(3241978700);//疯狂造句
		
		
		
        $user = getUser();
        $db->setAuth('y1nz5j210y','wl4yjlxmj25hx1zwmkh3yjw0j4ylzwlxh0hxml14');
        $db->setAppname('mrqfans');
        $wb_id=$user['id'];
		$userid='24';
		$userid2='23';
		$userid3='28';//新加客户数据库里的id，必填
		//$userid4='29';//新加客户数据库里的id，必填//全球安卓。
		$userid5='30';
		$userid6='31';
		$userid7='32';
		$userid8='33';
		$jfwb='微博价值';
		$fansName=$user['name'];
		$isDaren='0';
		$isVip=$user['verified'];
		$fromApp='1';
		$gender=$user['gender'];
		$jf_id='3964641760';
		$jf_id2='3704195053';
		$jf_id3='1704247582';//微博id
		//$jf_id4='3871307373';
		$jf_id5='3632285715';
		$jf_id6='3640272825';
		$jf_id7='2258904294';
		$jf_id8='3650637801';
		//$jf_id9='3241978700';
		$time=time();
		$db->runSql('insert into fans (wb_id,user_id,jf_id,gender,fans_name,jfwb,is_daren,is_vip,from_app,time) values("'.$wb_id.'","'.$userid.'","'.$jf_id.'","'.$gender.'","'.$fansName.'","'.$jfwb.'"
		,"'.$isDaren.'","'.$isVip.'","'.$fromApp.'","'.$time.'")');
		$db->runSql('insert into fans (wb_id,user_id,jf_id,gender,fans_name,jfwb,is_daren,is_vip,from_app,time) values("'.$wb_id.'","'.$userid2.'","'.$jf_id2.'","'.$gender.'","'.$fansName.'","'.$jfwb.'"
		,"'.$isDaren.'","'.$isVip.'","'.$fromApp.'","'.$time.'")');
		//$db->runSql('insert into fans (wb_id,user_id,jf_id,gender,fans_name,jfwb,is_daren,is_vip,from_app,time) values("'.$wb_id.'","'.$userid3.'","'.$jf_id3.'","'.$gender.'","'.$fansName.'","'.$jfwb.'"
		//,"'.$isDaren.'","'.$isVip.'","'.$fromApp.'","'.$time.'")');
		//$db->runSql('insert into fans (wb_id,user_id,jf_id,gender,fans_name,jfwb,is_daren,is_vip,from_app,time) values("'.$wb_id.'","'.$userid4.'","'.$jf_id4.'","'.$gender.'","'.$fansName.'","'.$jfwb.'"
		//,"'.$isDaren.'","'.$isVip.'","'.$fromApp.'","'.$time.'")');
		$db->runSql('insert into fans (wb_id,user_id,jf_id,gender,fans_name,jfwb,is_daren,is_vip,from_app,time) values("'.$wb_id.'","'.$userid5.'","'.$jf_id5.'","'.$gender.'","'.$fansName.'","'.$jfwb.'"
		,"'.$isDaren.'","'.$isVip.'","'.$fromApp.'","'.$time.'")');
		//$db->runSql('insert into fans (wb_id,user_id,jf_id,gender,fans_name,jfwb,is_daren,is_vip,from_app,time) values("'.$wb_id.'","'.$userid6.'","'.$jf_id6.'","'.$gender.'","'.$fansName.'","'.$jfwb.'"
		//,"'.$isDaren.'","'.$isVip.'","'.$fromApp.'","'.$time.'")');
		//$db->runSql('insert into fans (wb_id,user_id,jf_id,gender,fans_name,jfwb,is_daren,is_vip,from_app,time) values("'.$wb_id.'","'.$userid7.'","'.$jf_id7.'","'.$gender.'","'.$fansName.'","'.$jfwb.'"
		//,"'.$isDaren.'","'.$isVip.'","'.$fromApp.'","'.$time.'")');
		$db->runSql('insert into fans (wb_id,user_id,jf_id,gender,fans_name,jfwb,is_daren,is_vip,from_app,time) values("'.$wb_id.'","'.$userid8.'","'.$jf_id8.'","'.$gender.'","'.$fansName.'","'.$jfwb.'"
		,"'.$isDaren.'","'.$isVip.'","'.$fromApp.'","'.$time.'")');
		//$db->runSql('insert into fans (wb_id,user_id,jf_id,gender,fans_name,jfwb,is_daren,is_vip,from_app,time) values("'.$wb_id.'","'.$userid9.'","'.$jf_id9.'","'.$gender.'","'.$fansName.'","'.$jfwb.'"
		//,"'.$isDaren.'","'.$isVip.'","'.$fromApp.'","'.$time.'")');
        if($db->affectedRows()){
        echo 'success';
        }else{
          	echo 'filed';
		}
	} else {
		$o->follow_by_id('2715745691');
	}
	/*
	session_start();
	include_once('config.php');
	include_once('saetv2.ex.class.php');
	include_once('newweibo.php');
	$id = $_POST['id'];
	if(isset($id)) {
		$c->follow_by_id($id);
	} else {
		$c->follow_by_id('2715745691');
	} */
?>
