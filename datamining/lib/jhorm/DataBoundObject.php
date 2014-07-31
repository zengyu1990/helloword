<?php
abstract class DataBoundObject extends DataMapInterface{
	protected $ID;
	protected $blForDeletion;
	protected $blIsloaded = false;
	protected $arModifiedRelations;
	
	public function __construct($id = NULL){
		parent::__construct();
		//$this->adaptPDO();
		if(isset($id)){
			$this->ID = $id;
		};
		$this->arModifiedRelations = array();
	}
	/**
	 * 加载数据，有缓存功能，自动填充本对象属性
	 * @author johnshwang
	 * @param int $closeCache
	 * 
	 */
	public function Load($closeCache = false){
		if(isset($this->ID)){
			if($this->enableCache == 1 && !$closeCache) //启动的缓存模式
			{
				@$mmc = memcache_init();
				if($mmc)//系统支持Memcache
				{
					if( $arRow = memcache_get($mmc,"db_".$this->strTableName."_data_cache_".$this->ID)){
						//获取缓存
					} else {//没有缓存，从数据库里面读取
						$this->adaptPDO();
						$strQuery = "SELECT ";
						foreach ($this->arRelationMap as $key => $value){
							$strQuery.= $key . ",";
						};
						$strQuery = substr($strQuery,0,strlen($strQuery)-1);
						$strQuery.= " FROM " . $this->strTableName . " WHERE ".$this->tableInfo['primary']." = :eid ";
						$objStatement = $this->slavePDO->prepare($strQuery);
						$objStatement -> bindParam(':eid',$this->ID,PDO::PARAM_INT);
						$objStatement -> execute();
						$arRow = $objStatement->fetch(PDO::FETCH_ASSOC);
						memcache_set($mmc,"db_".$this->strTableName."_data_cache_".$this->ID,$arRow);//缓存数据
					}
					
				} else {//系统不支持Memcache
						$this->adaptPDO();
						$strQuery = "SELECT ";
						foreach ($this->arRelationMap as $key => $value){
							$strQuery.= $key . ",";
						};
						$strQuery = substr($strQuery,0,strlen($strQuery)-1);
						$strQuery.= " FROM " . $this->strTableName . " WHERE ".$this->tableInfo['primary']." = :eid ";
						$objStatement = $this->slavePDO->prepare($strQuery);
						$objStatement -> bindParam(':eid',$this->ID,PDO::PARAM_INT);
						$objStatement -> execute();
						$arRow = $objStatement->fetch(PDO::FETCH_ASSOC);
				}
				if($arRow > 0){
					foreach ($arRow as $key => $value){
						$strMember = $this->arRelationMap[$key];
						if(property_exists($this, $strMember)){
							if(is_numeric($value)){
								eval('$this->' . $strMember . '=' . $value . ';');
							} else {
								eval('$this->' . $strMember . '="' . $value .'";' );
							};
						};
					};
					$this->blIsloaded = true;
					return;
				} else {
					$this->blIsloaded = false;
					return;
				}
			}else{  //没有开启缓存模式
				$this->adaptPDO();
				$strQuery = "SELECT ";
				foreach ($this->arRelationMap as $key => $value){
					$strQuery.= $key . ",";
				};
				$strQuery = substr($strQuery,0,strlen($strQuery)-1);
				$strQuery.= " FROM " . $this->strTableName . " WHERE ".$this->tableInfo['primary']." = :eid ";
				$objStatement = $this->slavePDO->prepare($strQuery);
				$objStatement -> bindParam(':eid',$this->ID,PDO::PARAM_INT);
				$objStatement -> execute();
				$arRow = $objStatement->fetch(PDO::FETCH_ASSOC);
				if($arRow > 0){
					foreach ($arRow as $key => $value){
						$strMember = $this->arRelationMap[$key];
						if(property_exists($this, $strMember)){
							if(is_numeric($value)){
								eval('$this->' . $strMember . '=' . $value . ';');
							} else {
								eval('$this->' . $strMember . '="' . $value .'";' );
							};
						};
					};
					$this->blIsloaded = true;
					return;
				} else {
					$this->blIsloaded = false;
					return;
				}
			}
		};
	}
	/**
	 * 保存，当缓存启动的时候，小心使用;
	 * @author johnshwang
	 */
	public function Save(){
		$this->adaptPDO();
		if(isset($this->ID)){
			$strQuery = 'UPDATE ' . $this->strTableName . ' SET ';
			foreach ($this->arRelationMap as $key => $value){
				eval('$actualVal = &$this->' . $value . ';');
				if(array_key_exists($value, $this->arModifiedRelations)){
					$strQuery .=  $key . " = :$value,";
				};
			}
			$strQuery = substr($strQuery,0,strlen($strQuery)-1);
			$strQuery .= ' WHERE '.$this->tableInfo['primary'].' = :eid';
			unset($objStatement);
			$objStatement = $this->objPDO->prepare($strQuery);
			$objStatement -> bindValue(':eid', $this->ID, PDO::PARAM_INT);
			foreach ($this->arRelationMap as $key => $value){
				eval('$actualVal = &$this->' . $value . ';');
				if($actualVal != NULL && $key != $this->tableInfo['primary'])
					$arRow[$key] = $actualVal;
				if(array_key_exists($value, $this->arModifiedRelations)){
					if((is_int($actualVal)) || ($actualVal == NULL)){
						$objStatement->bindValue(':' . $value, $actualVal, PDO::PARAM_INT);
					} else {
						$objStatement->bindValue(':' . $value, $actualVal, PDO::PARAM_STR);
					};
				};
			}
			$objStatement->execute();
// 			if($this->enableCache == 1) //启动的缓存模式
// 			{
				@$mmc = memcache_init();
				if($mmc)//开启了Memcache
				{
					$arRowOld = memcache_get($mmc,"db_".$this->strTableName."_data_cache_".$this->ID);
					if($arRowOld){
						foreach($arRow as $key => $v)
							$arRowOld[$key] = $v;
						memcache_set($mmc,"db_".$this->strTableName."_data_cache_".$this->ID,$arRowOld);//缓存数据
					}
				}
// 			}
		} else {
			$strValueList = "";
			$strQuery = 'INSERT INTO ' . $this->strTableName . '(';
			foreach ($this->arRelationMap as $key => $value){
				eval('$actualVal = &$this->' . $value . ';');
				if(isset($actualVal)){
					if(array_key_exists($value, $this->arModifiedRelations)) {
						$strQuery .=  $key . ',';
						$strValueList .= ":$value," ;
					};
				};
			}
			$strQuery = substr($strQuery, 0, strlen($strQuery)-1);
			$strValueList = substr($strValueList, 0, strlen($strValueList)-1);
			$strQuery .= ") VALUES (";
			$strQuery .= $strValueList;
			$strQuery .= ")";
			unset($objStatement);
			$this->lastSQL = $strQuery;
			$objStatement = $this->objPDO->prepare($strQuery);
			foreach ($this->arRelationMap as $key => $value){
				eval('$actualVal = &$this-> ' . $value . ';');
				if(isset($actualVal)){
					if(array_key_exists($value, $this->arModifiedRelations)) {
						if($actualVal != NULL && $key != $this->tableInfo['primary'])
							$arRow[$key] = $actualVal;
						if((is_int($actualVal)) || ($actualVal == NULL)){
							$objStatement->bindValue(':' . $value, $actualVal, PDO::PARAM_INT);
						} else {
							$objStatement->bindValue(':' . $value, $actualVal, PDO::PARAM_STR);
						};
					};
				};
			}
			$objStatement->execute();
			$this->ID = $this->objPDO->lastInsertId($this->strTableName . "_id_seq");
			$arRow[$this->tableInfo['primary']] = $this->ID;
// 			if($this->enableCache == 1) //启动的缓存模式
// 			{
// 				@$mmc = memcache_init();
// 				if($mmc)//开启了Memcache
// 				{
// 					$arRowOld = memcache_get($mmc,"db_".$this->strTableName."_data_cache_".$this->ID);
// 					if($arRowOld)//假如存在缓存，则更新
// 					{
// 						foreach($arRow as $key => $v)
// 							$arRowOld[$key] = $v;
// 						memcache_set($mmc,"db_".$this->strTableName."_data_cache_".$this->ID,$arRowOld);//缓存数据
				
// 					}
// 				}
// 			}
		}
	
	}
	public function Replace(){
		$this->adaptPDO();
		$strValueList = "";
		$strQuery = 'REPLACE ' . $this->strTableName . '(';
		foreach ($this->arRelationMap as $key => $value){
			eval('$actualVal = &$this->' . $value . ';');
			if(isset($actualVal)){
				if(array_key_exists($value, $this->arModifiedRelations)) {
					$strQuery .=  $key . ',';
					$strValueList .= ":$value," ;
				};
			};
		}
		$strQuery = substr($strQuery, 0, strlen($strQuery)-1);
		$strValueList = substr($strValueList, 0, strlen($strValueList)-1);
		$strQuery .= ") VALUES (";
		$strQuery .= $strValueList;
		$strQuery .= ")";
		unset($objStatement);
		$objStatement = $this->objPDO->prepare($strQuery);
		foreach ($this->arRelationMap as $key => $value){
			eval('$actualVal = &$this-> ' . $value . ';');
			if(isset($actualVal)){
				if(array_key_exists($value, $this->arModifiedRelations)) {
					if((is_int($actualVal)) || ($actualVal == NULL)){
						$objStatement->bindValue(':' . $value, $actualVal, PDO::PARAM_INT);
					} else {
						$objStatement->bindValue(':' . $value, $actualVal, PDO::PARAM_STR);
					};
				};
			};
		}
		$objStatement->execute();
	}
	/**
	 * 冲入缓存,$key最好使用唯一字段
	 * @author johnshwang
	 */
	public function Buffer($key = 'ID'){
		@$mmc = memcache_init();
		$arRow = $this->toArray();
		if($mmc){
			memcache_set($mmc,"db_".$this->strTableName."_data_cache_".$key."_".$arRow[$key],$arRow);
		};
	}
	/**
	 * 获得缓存
	 * @author johnshwang
	 */
	public function obtainBuffer($key = 'ID'){
		@$mmc = memcache_init();
		$arRow = $this->toArray();
		if($mmc){
			$arRow = memcache_get($mmc,"db_".$this->strTableName."_data_cache_".$key."_".$arRow[$key]);
		};
		if($arRow){
			return $arRow;
		}else{
			return null;
		};
	}
	/**
	 * 删除数据
	 */
	public function MarkForDeletion(){
		$this->blForDeletion = true;
	}
	/**
	 * 对象回收操作
	 */
	public function __destruct(){
		$this->adaptPDO();
		if(isset($this->ID)){
			if($this->blForDeletion ==true){
				$strQuery = 'DELETE FROM ' .$this->strTableName . ' WHERE '.$this->tableInfo['primary'].' = :eid';
				$objStatement = $this->objPDO->prepare($strQuery);
				$objStatement->bindValue(':eid', $this->ID, PDO::PARAM_INT);
				$objStatement->execute();
			};
		};
	}
	public function __call($strFunction, $arArguments){
		$strMethodType = substr($strFunction, 0, 3);
		$strMethodMember = substr($strFunction, 3);
		switch($strMethodType){
			case "set":
				return ($this->SetAccessor($strMethodMember,$arArguments[0]));
				break;
			case "get":
				return ($this->GetAccessor($strMethodMember));
		}
		return(false);
	}
	private function SetAccessor($strMember, $strNewValue) {
		if(property_exists($this, $strMember)){
			if(is_numeric($strNewValue)) {
				eval('$this->' . $strMember . '=' . $strNewValue . ';');
			} else {
				eval('$this->' . $strMember . '="' . $strNewValue . '";');
			};
			$this->arModifiedRelations[$strMember] = "1";
		} else {
			return(false);
		}
	}
	private function GetAccessor($strMember){
		if($this->blIsloaded != true){
			$this->Load();
		}
		if(property_exists($this, $strMember)){
			eval('$strRetVal = $this->' . $strMember .';');
			return($strRetVal); 
		} else {
			return(false);
		}
	}
}
?>