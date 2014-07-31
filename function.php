<?php
#@author 陈书阳

/**
 * 通过UID取余对用户进行伪分类
 * @param int $uid 用户UID
 * @param int $mod 模
 * @return int 返回权值
 */
	function getWeight($uid, $mod) {
		return $uid % $mod;
	}

/**
 * 计算微博年龄
 * @param string $created_at API返回时间戳
 * @return string 天数
 */
	function weiboold($created_at) {
		$created_at = strtotime($created_at);
		$regday = date('Y-m-d', $created_at);
		$today = date('Y-m-d');
		$interval = date_diff(date_create($regday), date_create($today));
		$diff = $interval->format('%a');
		return $diff;
	}

/**
 * 获取N个最新发微博的用户
 * @param object $c 授权对象
 * @param int $number 用户人数
 * @param int $type 选择返回格式 1.字符串 2.数组
 * @return string 返回字符串，一次调用
 * @return array 返回数组，用于分开调用
 */
	function atFansLast($c, $number, $type) {
		$fansnamelist_str = '';
		$fansnamelist = array();
		$user_message = $c->public_timeline(1, $number, 0);
		if (is_array($user_message['statuses'])) {
			foreach ($user_message['statuses'] as $item) {
				$fansnamelist_str .= "@".$item['user']['name']." ";
				array_push($fansnamelist, "@".$item['user']['name']." ");
			}
		}
		if ($type == 1) {
			return $fansnamelist_str;
		} else if ($type == 2) {
			return $fansnamelist;
		}
	}

/**
 * 从第N个互粉粉丝开始选出M+F个粉丝（M为男性，F为女性），若互粉不足，则选N个最新微博的作者
 * @param object $c 授权对象
 * @param int $uid 授权用户的UID
 * @param int $begin 互粉起始数
 * @param int $male @的男性人数
 * @param int $female @的女性人数
 * @param int $type 选择返回格式 1.字符串 2.数组
 * @return string 返回字符串，一次调用
 * @return array 返回数组，用于分开调用
 */
	function atFansDiffGender($c, $uid, $begin, $male, $female, $type) {
		$m_num = $f_num = $page = 0;
		$keyarray = $valuearray = array();
		$fansnamelist_str = '';
		$fansnamelist = array();
		$malelist_str = $femalelist_str = '';
		$malelist = $femalelist = array();
		$number = $male + $female;
		do {
			$page++;
			$user_message = $c->bilateral($uid, $page, 50, 0);
			if (is_array($user_message['users'])) {
				foreach ($user_message['users'] as $item) {
					array_push($keyarray, $item['name']);
					array_push($valuearray, $item['favourites_count']);
				}
			}
		} while ($page < $user_message['total_number'] / 50);
		if (count($keyarray) <= $number) {
			//$fansnamelist = atFansLast($c, $number, 2);
		} else {
			$mostfansfavourite = array_combine($keyarray, $valuearray);
			arsort($mostfansfavourite);
			if($begin >= count($mostfansfavourite)) {
				//$fansnamelist = atFansLast($c, $number, 2);
			} else {
				$count = count($mostfansfavourite) - $begin;
				$new_fansfavourite = array_slice($mostfansfavourite, $begin, $count);
				foreach ($new_fansfavourite as $key => $value) {
					$user_message = $c->show_user_by_name($key);
					$gender = $user_message['gender'];
					if ($key == null) {
						//$fansnamelist = atFansLast($c, $number, 2);
					}
					if ($gender == 'm' && $m_num < $male) {
						$malelist_str .= "@".$key." ";
						array_push($malelist, "@".$key." ");
						$m_num++;
					}
					if ($gender == 'f' && $f_num < $female) {
						$femalelist_str .= "@".$key." ";
						array_push($femalelist, "@".$key." ");
						$f_num++;
					}
					if ($f_num == $female && $m_num == $male) {
						break;
					}
				}
				$fansnamelist_str =$malelist_str.$femalelist_str;
				$fansnamelist = array_merge($malelist, $femalelist);
			}
		}
		if ($type == 1) {
			return $fansnamelist_str;
		} else if ($type == 2) {
			return $fansnamelist;
		}
	}

/**
 * 从最近评论我的列表中，提取互粉好友，若不足，用互粉中，收藏数较多的好友补充。
 * @param object $c 授权对象
 * @param int $uid 授权用户的UID
 * @param int $page 计算页数
 * @param int $male @的男性人数
 * @param int $female @的女性人数
 * @return array 返回数组，用于分开调用
 */
	function atFansPro($c, $uid, $page, $male, $female) {
		$commentlist = $malelist = $femalelist = array();
		$femalefans = $malefans = array();
		$male_key = $male_value = $female_key = $female_value = array();
		for($i = 1; $i <= $page; $i++) {
			$commentlist = $c->comments_to_me($i, 50, 0, 0, 1, 0);
			if(is_array($commentlist['comments'])) {
				foreach ($commentlist['comments'] as $item) {
					if($item['user']['follow_me'] == true) {
						if($item['user']['gender'] == 'm') {
							array_push($malelist, '@'.$item['user']['name'].' ');
						} else if ($item['user']['gender'] == 'f') {
							array_push($femalelist, '@'.$item['user']['name'].' ');
						}
					}
				}
			}
		}
		$malelist = array_values(array_unique($malelist));
		$femalelist = array_values(array_unique($femalelist));
		shuffle($malelist);
		shuffle($femalelist);
		$malefans = array_slice($malelist, 0, $male);
		$femalefans = array_slice($femalelist, 0, $female);
		if(count($malefans) < $male || count($femalefans) < $female) {
			$user_message = $c->bilateral($uid, 1, 100, 0);
			if (is_array($user_message['users'])) {
				foreach ($user_message['users'] as $item) {
					if($item['gender'] == 'm') {
						array_push($male_key, '@'.$item['name'].' ');
					} else if ($item['gender'] == 'f') {
						array_push($female_key, '@'.$item['name'].' ');
					}
				}
			}
			if(count($malefans) < $male && count($male_key) != 0) {
				do {
					if(count($male_key) == 0) {
						break;
					}
					$seed = mt_rand(0, count($male_key) - 1);
					if(!in_array($male_key[$seed], $malefans)) {
						array_push($malefans, $male_key[$seed]);
						unset($male_key[$seed]);
					}
				} while(count($malefans) != $male);
			}
			if(count($femalefans) < $female && count($female_key) != 0) {
				do {
					if(count($female_key) == 0) {
						break;
					}			
					$seed = mt_rand(0, count($female_key) - 1);
					if(!in_array($female_key[$seed], $femalefans)) {
						array_push($femalefans, $female_key[$seed]);
						unset($female_key[$seed]);
					}
				} while(count($femalefans) != $female);
			}
		}
		$fanslist = array_values(array_unique(array_merge($malefans, $femalefans)));
		return $fanslist;
	}
?>