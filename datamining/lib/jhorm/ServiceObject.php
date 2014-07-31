<?php
/**
 * @author johnshwang
 *
 */
abstract class ServiceObject extends DataMapInterface{
	
	protected $PersistenceFactory;
	
	abstract protected function DefinePersistenceFactory();
	
	public function __construct(){
		parent::__construct();
		$this->adaptPDO();
		$this->PersistenceFactory = $this->DefinePersistenceFactory();
	}
	
	
	//public function findByMultiProperty($property,$value){ 旧版本方法名
	/**
		方法名:findByProperty
		新版本方法:根据property和value的对应,查询数据库并返回对应的对象数据. 拓展两个参数orderby ,sort 用作排序
		根据property,value的对应关系返回对象数组,property,value可以是数组也可以是两个值.但必须长度绝对相等.
	*/
	public function findByProperty($property,$value,$orderby = NULL,$sort = NUll){	
		$arr_value = array();
		$arr_property = array();
		if(count($property)!=count($value))
		{
			echo "parameter unequal length ".count($property)."!=".count($value);//debug log
			return false;
		}
		if(!is_array($property))
		{
			$arr_property[0] = $property;
		}else{
			$arr_property = $property;
		}
		if(!is_array($value))
		{
			$arr_value[0] = $value;
		}else{
			$arr_value = $value;
		}
		
		$id = array_keys($this->arRelationMap,"ID");
		$strQuery = "SELECT ".$id[0]." FROM " . $this->strTableName . " WHERE ";
		for($i = 0 ;$i<count($arr_property) ; $i++){
			$field[$i] = array_keys($this->arRelationMap,$arr_property[$i]);
			if(!$field[$i]){
				echo "property error!";//debug log
				return false;
			}
			if(!is_numeric($arr_value))
				$arr_value[$i] = "'".$arr_value[$i]."'";
			$strQuery .= $field[$i][0].' = '.$arr_value[$i] . ' AND ';
		}
		$strQuery = substr($strQuery,0,strlen($strQuery)-4);
		//echo $strQuery."<br>";
		if(isset($orderby)){
			$orderby_field = array_keys($this->arRelationMap,$orderby);
			if(!$orderby_field){
				echo "orderby error!";//debug log
				return false;
			}
			$sorttest = 'ASC';
			if(isset($sort))
			{
				if($sort!='ASC' && $sort!='DESC'){
					echo "sort error!";//debug log
					return false;
				}
				$sorttest = $sort;
			}
			$strQuery .= " ORDER BY ".$orderby_field[0]." ".$sorttest;
		}
// 		echo $strQuery."<br>";
		$objStatement = $this->slavePDO->prepare($strQuery);
		$objStatement -> execute();
		if($objStatement->rowCount() == 0)
		{	
			//echo 'not found';//debug log
			return null;
		}
		$re = array();
		while($arRow = $objStatement->fetch())
		{
			array_push($re,$this->PersistenceFactory->GetObject($arRow[$id[0]]));
		}
		return $re;
		
	}
	/**
		方法名:isExistByProperty
		新版本方法功能:判断是否存在property和value对应映射的记录.假如存在返回记录数.
		property,value可以是数组也可以是两个值.但必须长度绝对相等.
	*/
	public function isExistByProperty($property,$value){
		$arr_value = array();
		$arr_property = array();
		if(count($property)!=count($value))
		{
			return false;
		}
		if(!is_array($property))
		{
			$arr_property[0] = $property;
		}else{
			$arr_property = $property;
		}
		if(!is_array($value))
		{
			$arr_value[0] = $value;
		}else{
			$arr_value = $value;
		}
		$id = array_keys($this->arRelationMap,"ID");
		$strQuery = "SELECT ".$id[0]." FROM " . $this->strTableName . " WHERE ";
		for($i = 0 ;$i<count($arr_property) ; $i++){
			$field[$i] = array_keys($this->arRelationMap,$arr_property[$i]);
			if(!is_numeric($arr_value))
				$arr_value[$i] = "'".$arr_value[$i]."'";
			$strQuery .= $field[$i][0].' = '.$arr_value[$i] . ' AND ';
		}
		$strQuery = substr($strQuery,0,strlen($strQuery)-4);
		echo $strQuery."<br>";
		$objStatement = $this->slavePDO->prepare($strQuery);
		$objStatement -> execute();
		if($objStatement->rowCount() >= 0)
			return $objStatement->rowCount();
		else
			return false;
	}

	public function findByPropertyWhereMultiValue($property,$value,$orderby = NULL,$sort = NUll){
		
		$arr_value = array();
		
		if(!is_array($value))
		{
			$arr_value[0] = $value;
		}else{
			$arr_value = $value;
		}
		
		$id = array_keys($this->arRelationMap,"ID");
		$field = array_keys($this->arRelationMap,$property);
		$strQuery = "SELECT ".$id[0]." FROM " . $this->strTableName . " WHERE ".$field[0]." IN ";
		for($i = 0 ;$i<count($arr_value) ; $i++){
			if(!is_numeric($arr_value))
				$arr_value[$i] = "'".$arr_value[$i]."'";
		}
		$sqlvalue = implode(",", $arr_value);
		$strQuery .= " ( ".$sqlvalue." ) ";
// 		echo $strQuery."<br>";
		if(isset($orderby)){
			$orderby_field = array_keys($this->arRelationMap,$orderby);
			if(!$orderby_field){
				echo "orderby error!";//debug log
				return false;
			}
			$sorttest = 'ASC';
			if(isset($sort))
			{
				if($sort!='ASC' && $sort!='DESC'){
					echo "sort error!";//debug log
					return false;
				}
				$sorttest = $sort;
			}
			$strQuery .= " ORDER BY ".$orderby_field[0]." ".$sorttest;
		}
		//		echo $strQuery."<br>";
		$objStatement = $this->slavePDO->prepare($strQuery);
		$objStatement -> execute();
		if($objStatement->rowCount() == 0)
		{
// 			echo 'not found';//debug log
			return null;
		}
		$re = array();
		while($arRow = $objStatement->fetch())
		{
			array_push($re,$this->PersistenceFactory->GetObject($arRow[$id[0]]));
		}
		return $re;
		
	}

	public function createDetachedSQL(){
		return new DetachedSQL();
	}
	
	public function findByDetachedSQL(DetachedSQL $dsql){
// 		$id = array_keys($this->arRelationMap,"ID");
		$strQuery = "SELECT ".$this->tableInfo['primary']." FROM " . $this->strTableName . " ";
// 		$strQuery = "SELECT ".$id[0]." FROM " . $this->strTableName . " ";
	//	echo $dsql->generateSQL();
		$strQuery .= $dsql->generateSQL();
//		echo $strQuery."<br>";
		$this->lastSQL = $strQuery;
		$objStatement = $this->slavePDO->prepare($strQuery);
		$objStatement -> execute();
		if($objStatement->rowCount() == 0)
		{
// 			echo 'not found';//debug log
			return null;
		}
		$re = array();
		while($arRow = $objStatement->fetch())
		{
			array_push($re,$this->PersistenceFactory->GetObject($arRow[$this->tableInfo['primary']]));
		}
		if(count($re) == 1)
			return $re[0];
		return $re;
	}
	
	public function countByDetachedSQL(DetachedSQL $dsql){
		
		$strQuery = "SELECT COUNT(*) FROM " . $this->strTableName . " ";
		$strQuery .= $dsql->generateSQLWhere();
		$this->lastSQL = $strQuery;
		$objStatement = $this->slavePDO->query($strQuery);
		$arRow = $objStatement->fetch();
		return $arRow[0];
		
	}
	
	public function findPageByDetachedSQL(DetachedSQL $dsql, $current_page = 1, $page_size = 20){
		
		$cdsql = clone $dsql;
		$totalRows = $this->countByDetachedSQL($dsql);
		if($totalRows>0)
		{
			$offset = ($current_page-1) * $page_size;//位置
			$cdsql->limit($page_size,$offset);
			$data = $this->findByDetachedSQL($cdsql);
			if($data)
			{
				if(!is_array($data))
					$data[0] = $data;
				foreach($data as &$v)
				{
					$v = $v->toArray();
				}
			}
		}
		$page = new Page($data,$totalRows,$current_page,$page_size);
		return $data;
// 		return $Page;
	}
}