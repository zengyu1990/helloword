<?php 
/**
 * 判断字母是否为大写
 * @param String $char 字母
 */
function IsUpperCase($char){
	$ascii = ord($char);
	if($ascii >= 65 && $ascii <= 90){
		return true;
	}else{
		return false;
	}
}

