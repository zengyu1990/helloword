<?php
define('JHORM_SERVICE_DIR',dirname(__FILE__).'/../../service/');
define('JHORM_VO_DIR',dirname(__FILE__).'/../../vo/');
define('JHORM_VO_FACTORY_DIR',dirname(__FILE__).'/../../vo/factory/');
require_once 'db-config.php';
require_once 'ORM-functions.php';
require_once 'PDOFactory.php';
require_once 'DataMapInterface.php';
require_once 'DataBoundObject.php';
require_once 'ServiceObject.php';
require_once 'DetachedSQL.php';
require_once 'Restrictions.php';
require_once 'Order.php';