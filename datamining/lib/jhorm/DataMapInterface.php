<?php
/**
 * 数据接口类
 * @author johnshwang
 *
 */
abstract class DataMapInterface{
	
	protected $strTableName;
	protected $arRelationMap;
	protected static $tableInfo;
	protected $reSetRelationMap = 0;
	protected $lastSQL;               //最后一次执行的sql
	protected $enableCache = 0;       //默认关闭缓存
	protected $objPDO;                //写数据库
	protected $slavePDO;              //从数据库
	
	abstract protected function DefineTableName();
	abstract protected function DefineRelationMap();
	/**
	 * 构造函数
	 * @author johnshwang
	 */
	public function __construct(){
		$this->strTableName = $this->DefineTableName();//初始化数据库表名
//  	$this->arRelationMap = $this->DefineRelationMap();
//		$this->connectDB();        //建立数据库连接 pdo
		$this->DefineTableInfo();  //获取数据表信息
		$this->autoMapping();      //对象属性映射
	}
	/**
	 * 适配PDO驱动
	 */
	public function adaptPDO(){
		if(empty($this->objPDO))
			$this->connectDB();
	}
	/**
	 * 连接数据库
	 * @author johnshwang
	 */
	public function connectDB(){
		$arParms = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",PDO::MYSQL_ATTR_INIT_COMMAND => "set character set utf8");
		if(DBMasterSlave == true){
			$this->objPDO = PDOFactory::GetPDO(WRITE_DB_DSN,WRITE_DB_USER,WRITE_DB_PASSWORD,$arParms);
			$this->slavePDO = PDOFactory::GetPDO(READ_DB_DSN,READ_DB_USER,READ_DB_PASSWORD,$arParms);
		}else{
			$this->objPDO = PDOFactory::GetPDO(WRITE_DB_DSN,WRITE_DB_USER,WRITE_DB_PASSWORD,$arParms);
			$this->slavePDO = &$this->objPDO;
		}
	}
	/**
	 * 开启缓存模式
	 * @author johnshwang
	 */
	public function enableCache(){
		$this->enableCache = 1;
	}
	
	/**
	 * 自动映射属性
	 * @author johnshwang
	 */
	private function autoMapping(){
		if(is_array($this->tableInfo['field']))
		{
			foreach($this->tableInfo['field'] as $v){
				if($v['primary'] != 1) 
				{
					$this->arRelationMap[$v['name']] = $this->transformNamingRulesToProperty($v['name']);
				}else{
					$this->arRelationMap[$v['name']] = 'ID';
				}
			}
		}
	}
	
	/**
	 * 设置数据库PDO,具有主从之分
	 * @author johnshwang
	 * @param PDO $objPDO PDO实体
 	 */
	public function setPDO(PDO $objPDO , PDO $slaveobjPDO = null){
		if($slaveobjPDO == null)
		{	
			$this->objPDO = $objPDO;
			$this->slavePDO = &$this->objPDO;
		}else{
			$this->objPDO = $objPDO;
			$this->slavePDO = $slaveobjPDO;
		}
	}
	/**
	 * 设置字段,自定义属性映射
	 * @author johnshwang
	 *
	 */
	public function setFeild($Feild,$Property = null){
		if($this->reSetRelationMap = 0){	
			$this->arRelationMap = array();
			$this->arRelationMap[$this->tableInfo['primary']] = 'ID';
			$this->reSetRelationMap = 1;          //设置为已经被重置map
		}else{
			if($Property == null)
			{
				$this->arRelationMap[$this->transformNamingRules($Feild)] = $Feild;
			}else{
				$this->arRelationMap[$this->transformNamingRules($Feild)] = $Property;
			}
		}
	}
	/**
	 * 数据库字段->类属性
	 * @author johnshwang
	 * @param String $property 类属性   user_name => UserName
	 */
	public function transformNamingRulesToProperty($field){
		if($field != 'id')
		{
			$property = trim($field);
			$property = str_replace('_',' ',$property);
			$property = ucwords($property);
			$property = str_replace(' ','',$property);
		}else{
			$property = 'ID';
		}
		return $property;
	}
	/**
	 * 类属性->数据库字段
	 * @author johnshwang
	 * @param String $property 类属性   UserName => user_name
	 */
	public function transformNamingRulesToField($property){
		if($property != 'ID')
		{
			$field = trim($property);
			$re = '';
			$c = strlen($field);
			for( $i = 0 ; $i < $c ; $i++  )
			{
				if(IsUpperCase($property[$i])){
					$re .= '_'.strtolower($property[$i]);
				}else{
					$re .= $property[$i];
				}
			}
			$field = substr( $re , 1 );
		}else{
			$field = 'id';
		}
		return $field;
	}
	/**
	 * 遍历对象属性,返回数组
	 * @author johnshwang
	 */
	public function toArray(){
		$this->Load();
		foreach($this->arRelationMap as $key => $value){
			$r[$value] = $this->$value;
		}
		return $r;
	}
	
	/**
	 * 从数据库中获取本数据库表信息
	 * @author johnshwang
	 * @param unknown_type $tableName
	 * @return multitype:multitype:boolean unknown
	 */
	public function getFieldsFromDB(){
		$this->connectDB();
		$result =   $this->slavePDO->query('SHOW COLUMNS FROM ' . $this->strTableName );
		$info   =   array();
		if($result) {
			foreach ($result as $key => $val) {
				$info['field'][$val['Field']] = array(
						'name'    => $val['Field'],
						'type'    => $val['Type'],
						'notnull' => (bool) ($val['Null'] === ''), // not null is empty, null is yes
						'default' => $val['Default'],
						'primary' => (strtolower($val['Key']) == 'pri'),
						'autoinc' => (strtolower($val['Extra']) == 'auto_increment'),
				);
				if(strtolower($val['Key']) == 'pri')
				{
					$info['primary'] = $val['Field'];
				}
			}
		}
		return $info;
	}
	/**
	 * 从MemCache缓存中获取数据表信息
	 * @author johnshwang
	 */
	public function getFieldsFromMemCache(){
		$mmc=memcache_init();
		if($mmc == false)
			echo "memcache启动失败";
		else
		{
			memcache_set($mmc,"table_info_".$this->strTableName,array(0,1,2,3,4));
			print_r(memcache_get($mmc,"table_info_".$this->strTableName));
		}
	}
	/**
	 * @author johnshwang
	 * 
	 */
	public function DefineTableInfo(){
		if(MemCache)//开启了Memcache
		{
			@$mmc = memcache_init();
			if($mmc)
			{
				if( $info = memcache_get($mmc,"table_info_".$this->strTableName)){//存在缓存
					$this->tableInfo = $info;
				}
				else { //没有缓存
					$this->tableInfo = $this->getFieldsFromDB();
					memcache_set($mmc,"table_info_".$this->strTableName,$this->tableInfo);
				}
			}else{ //系统不支持Memcache
				$this->tableInfo = $this->getFieldsFromDB();
			}
		} else {//没有开启Memcache
			$this->tableInfo = $this->getFieldsFromDB();
		}
	}
	
	public function printLastSQL(){
		echo $this->lastSQL;
	}
	
}