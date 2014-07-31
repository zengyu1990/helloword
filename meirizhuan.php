<?php
	$mysql = new SaeMysql();
	$id = $_GET['id'];
	$sql = "SELECT * FROM  `user_count` WHERE `id` = {$id}";
	$logs = $mysql->getData($sql);
	$sql = "SELECT * FROM `meirizhuan` WHERE `id` = {$id}";
	$check = $mysql->getData($sql);
	print_r($check);
	if (!empty($check)) {
		die();
	}
	if ($id) {
		$log = $logs[0];
		include_once('config.php');
		include_once('saetv2.ex.class.php');
		$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $log['token']);
		$comments = $c->comments_to_me(1, 200);
		if (isset($comments['comments'])) {
			$i = 0;
			foreach ($comments['comments'] as $val) {
				if (stripos($val['source'], 'iphone') !== false) {
					$ret = $c->reply($val['status']['id'], '这是我朋友开发的APP，支持一下，iPhone可以直接安装 http://weibojz.sinaapp.com/url.php, 如果可以的话帮忙传播一下[可怜][可怜]', $val['id']);
					if ($i >= 5) {
						//break;
					} else {
						$i++;
					}
					print_r($ret);
					if (isset($ret['created_at'])) {
						$sql = "INSERT INTO `log`(`count_id`, `by_user`, `by_mid`, `message`) VALUES ({$log['id']}, {$log['uid']}, {$val['status']['id']}, 'success')";
						$mysql->runSql($sql);
					} else {
						$sql = "INSERT INTO `log`(`count_id`, `by_user`, `by_mid`, `message`) VALUES ({$log['id']}, {$log['uid']}, {$val['status']['id']}, 'fail')";
						$mysql->runSql($sql);
					}
					sleep(1);
				}
			}
		} else {
			print_r($comments);
			$return_mesg = isset($comments['error']) ? $comments['error'] : '';
			$sql = "INSERT INTO `log`(`count_id`, `by_user`, `message`, `return_mesg`) VALUES ({$log['id']}, {$log['uid']}, 'token has something problem', '{$return_mesg}')";
			$mysql->runSql($sql);
		}
		$sql = "INSERT INTO `meirizhuan`(`id`, `user_id`) VALUES ({$log['id']}, {$log['uid']})";
		$mysql-> runSql($sql);
		usleep(500000);
	} else {
		$sql = "SELECT * FROM  `user_count` WHERE `id` >= 333652 ORDER BY  `user_count`.`id` ASC LIMIT 2000";
		$logs = $mysql->getData($sql);
		$queue = new SaeTaskQueue('foo');
		$array = array();
		foreach ($logs as $log) {
			$array[] = array('url' => "http://weibojz.sinaapp.com/meirizhuan.php?id=".$log['id']);
		}
		$queue->addTask($array);
		$ret = $queue->push();
		 
		 //任务添加失败时输出错误码和错误信息
		 if ($ret === false) {
		    var_dump($queue->errno(), $queue->errmsg());
		 } else {
		 	echo 'come on baby'.count($logs);
		 }
	}