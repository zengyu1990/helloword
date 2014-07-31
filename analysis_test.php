<?php
						//分析微博价值的函数，加载时间特别长！！
						require_once 'phpexcel/Classes/PHPExcel/Calculation/Statistical.php';
						$objPHPExcel = new PHPExcel_Calculation_Statistical();
						$mean = 3300;
						$sd = 1800;
						$day = weiboold($my_message['created_at']);
						$day_index = 100 + $day * 0.1;
						if($my_message['verified'] == false) {
							$v_index = 1.4;
						} else {
							$v_index = 2.4;
						}
						$weibovalue = floor((107 + $my_message['followers_count'] * 12 + $my_message['statuses_count'] * 0.9) * ($day_index / 70) * $v_index);
						$rank = $objPHPExcel->NORMDIST($weibovalue, $mean, $sd, 1);
						if($weibovalue < $mean * 200) {
							if($weibovalue < $mean * 20) {
								if($rank < 0.9) {
									if($rank < 0.75) {
										if($rank < 0.5) {
											if($rank < 0.25) {
												if($rank < 0.2) {
													$rank += 0.02;
												} else {
													$rank += 0.04;
												}
											} else {
												$rank += 0.15;
											}
										} else {
											$rank += 0.1;
										}
									} else {
										$rank += 0.05;			
									}
								} else {
									$rank = 0.95;
								}
							} else {
								$rank = 0.97;
							}
						} else {
							$rank = 0.99;
						}
						if($rank >= 0.7) {
							$answer_title = '一个影响力巨大的高级账号';
						} else if($rank <= 0.35) {
							$answer_title = '一个新兴的微博账号';
						} else {
							$answer_title = '一个影响力快速增长的账号';
						}
						$rank = $rank * 100;
						if ($my_message['bi_followers_count'] <= 15) {
							$rand1 = 0;
							$rand2 = 0;
						} else if ($my_message['bi_followers_count'] <= 50){
							$rand1 = mt_rand(0, 5);
							$rand2 = mt_rand(0, 5);
						} else {
							$rand1 = mt_rand(0, 10);
							$rand2 = mt_rand(0, 10);
						}
						$imgtitle = '比我'.round($rank).'%的粉丝高';
						$imgtext = array("jieguo" => $weibovalue, "imgSay" => $imgtitle, "unitName" => "元", "uid" => $uid,"value_title"=>$answer_title);
						//$image = new ImgComposite();
						$image_url = '';//$image->__getWeiBoImg($imgtext);
						$fans = atFansPro($c, $uid, 4, 2, 3);
						$text = '我的微博已经开了'.$day.'天，一共发了'.$my_message['statuses_count'].'条微博，拥有'.$my_message['followers_count'].'位粉丝。总价值'.$weibovalue.'元！'.$fans[0].$fans[1].$fans[2].$fans[3].$fans[4].'你们的微博价值应该没我的高吧？不信进来测测就知道啦:http://weibojz.sinaapp.com';
					
					?>