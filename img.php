<?php
	$mmc = memcache_init();
	for ($i = 1; $i <= 8; $i++) {
		if ($mmc !== false) {
			${'img'.$i} = memcache_get($mmc, 'img'.$i);
			if (!${'img'.$i}) {
				${'img'.$i} = file_get_contents('resources/images/weibo/'.$i.'.gif');
				memcache_set($mmc, 'img'.$i, ${'img'.$i});
			}
		} else {
			${'img'.$i} = file_get_contents('resources/images/weibo/'.$i.'.gif');
		}
	}
	$data = $_POST['imgtext'];
	$str = $data['jieguo'];
	$save = new SaeStorage();
	$img6 = file_get_contents('resources/images/weibo/6.gif');
	$numText = new SaeImage($img6);
	$numFont = csubstr($str);
	$numText->annotate($str, '1', SAE_Center, $numFont);
	$numText->improve();
	$numData = $numText->exec('jpg', false);
	$img6 = $numData;
	$numText->clean();
	$img2 = file_get_contents('resources/images/weibo/2.gif');
	$baiText = new SaeImage($img2);
	$baiFont = array("name"=>SAE_MicroHei, "size"=>28, "weight"=>150, "color"=>"#FFFFFF");
	$baiText->annotate($data['imgSay'], '1', SAE_Center, $baiFont);
	$baiText->improve();
	$baiData = $baiText->exec('jpg', false);
	$img2 = $baiData;
	$baiText->clean();
	$img4 = file_get_contents('resources/images/weibo/4.gif');
	$unitText = new SaeImage($img4);
	$unitFont = array("name"=>SAE_MicroHei, "size"=>40, "weight"=>200, "color"=>"#FFFFFF");
	$unitText->annotate($data['unitName'], '1', SAE_Center, $unitFont);
	$unitText->improve();
	$unitData = $unitText->exec('jpg', false);
	//title
	$img8 = file_get_contents('resources/images/weibo/8.gif');
	$titleValue = new SaeImage($img8);
	$titleFont = array("name"=>SAE_MicroHei, "size"=>28, "weight"=>150, "color"=>"#fff6cf");
	$titleValue->annotate($data['value_title'],'1',SAE_Center ,$titleFont);
	$img8 = $titleValue->exec('jpg', false);
	$img4 = $unitData;
	$unitText->clean();
	$img3 = file_get_contents('resources/images/weibo/3.gif'); //大图
	$img1 = file_get_contents('resources/images/weibo/1.gif');
	$img5 = file_get_contents('resources/images/weibo/5.gif');
	$img7 = file_get_contents('resources/images/weibo/7.gif');
	$img = new SaeImage($img3);
	$size = $img->getImageAttr();
	$img->clean();
	$img->setData(array(
	array($img3, 0, 0, 1, SAE_TOP_LEFT), 
	array($img7, 0, 0, 1, SAE_TOP_LEFT), 
	array($img8, 0, 0, 1, SAE_TOP_LEFT), 
	array($img6, 0, -118, 1, SAE_TOP_LEFT), 
	array($img4, -31, 160, 1, SAE_BOTTOM_RIGHT), 
	array($img2, 0, 72, 1, SAE_BOTTOM_LEFT), 
	array($img1, 0, 0, 1, SAE_BOTTOM_LEFT), 
	));
	$img->composite($size[0], $size[1]);
	$img->improve();
	$weiImgData = $img->exec('jpg', false);
	$weiImg = $save->write('image', $data['uid'].'.jpg', $weiImgData);
	die(json_encode(array('sign' => true, 'image_url' => $weiImg)));

	function csubstr($str) {
		$str = trim($str);
		$strLen = strlen($str);
		if(ord(substr($str, $strLen-1, 1)) > 0xa0){
			$strStyle['name'] = SAE_MicroHei;
				switch($strLen){
					case 4: $strStyle['size'] = 119; break;
					case 5: $strStyle['size'] = 102; break;
					case 6: $strStyle['size'] = 87; break;
					case 7: $strStyle['size'] = 73; break;
					default: $strStyle['size'] = 55; break;
				}
		}else{
			$strStyle['name'] = SAE_Arial;
			switch($strLen){
				case 1: $strStyle['size'] = 200; break;
				case 2: $strStyle['size'] = 180; break;
				case 3: $strStyle['size'] = 132; break;
				case 4: $strStyle['size'] = 108; break;
				case 5: $strStyle['size'] = 87; break;
				case 6: $strStyle['size'] = 74; break;
				case 7: $strStyle['size'] = 62; break;
				default: $strStyle['size'] = 55; break;
			}
		}
		$strStyle['weight'] = 200;
		$strStyle['color'] = '#EC6941';
		return $strStyle;
	}
?>