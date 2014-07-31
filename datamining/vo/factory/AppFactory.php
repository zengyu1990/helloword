<?php
	class AppFactory{
		public static function GetObject($id = null){
			return new App($id);
		}
	}
?>