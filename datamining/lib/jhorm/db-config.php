<?php
define('DBMasterSlave',true);
define('MemCache',true);
define('WRITE_DB_DSN','mysql:host=w.rdc.sae.sina.com.cn;dbname=app_mrqams;port=3307');
define('WRITE_DB_USER', '3w354o102n');     
define('WRITE_DB_PASSWORD', '1mj32xz1k4j01zxjj3i0xil21zk1k45jl42z4hkw'); 

define('READ_DB_DSN','mysql:host=r.rdc.sae.sina.com.cn;dbname=app_mrqams;port=3307');
define('READ_DB_USER', '3w354o102n');
define('READ_DB_PASSWORD', '1mj32xz1k4j01zxjj3i0xil21zk1k45jl42z4hkw');

$arParms = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",PDO::MYSQL_ATTR_INIT_COMMAND => "set character set utf8");
//define('ABSPATH', dirname(__FILE__).'/');
?>