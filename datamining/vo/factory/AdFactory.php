<?php
class AdFactory{

	public static function GetObject($id = null){

		return new Ad($id);

	}
}
?>