<?php
class DetachedSQL{
	
	protected $Restrictions = Array();
	protected $Orders = Array();
	
	protected $strWhere='';
	protected $strOrder='';
	protected $strQuery='';
	protected $strLimit='';
	
	public function limit($limit , $offset = 0){
		if($offset)
			$this->strLimit = ' LIMIT '.$offset.','.$limit.' ';
		else
			$this->strLimit = ' LIMIT '.$limit.' ';
	}
	/**
	 * 注入Restrictions对象
	 * @author johnshwang
	 */
	public function add(Restrictions $Restrictions){
		
		array_push($this->Restrictions,$Restrictions);
	
	}
	/**
	 * 注入Order对象
	 * @author johnshwang
	 */
	public function addOrder(Order $order){
		
		array_push($this->Orders,$order);
		
	}
	/**
	 * 合并Where条件子句
	 * @author johnshwang
	 */
	public function generateSQLWhere(){
	
		for($i = 0; $i<count($this->Restrictions); $i++){
			if($i == 0){
				$this->strWhere .= ' WHERE '.$this->Restrictions[$i]->generateSQL();
			} else {
				$this->strWhere .= ' AND '.$this->Restrictions[$i]->generateSQL();
			}
		}
	//	echo $strQuery;
		return $this->strWhere;
	}
	/**
	 * 合并Order子句
	 * @author johnshwang
	 */
	public function generateSQLOrder(){
	
		for($i = 0; $i<count($this->Orders); $i++){
			if($i == 0){
				$this->strOrder .= ' ORDER BY '.$this->Orders[$i]->generateSQL();
			} else {
				$this->strOrder .= ' , '.$this->Orders[$i]->generateSQL();
			}
		}
	//	echo $strQuery;
		return $this->strOrder;
	}
	/**
	 * 构造查询语句
	 * @author johnshwang
	 */
	public function generateSQL(){
	
		$this->strQuery = $this->generateSQLWhere().' '.$this->generateSQLOrder().$this->strLimit;
		
		return $this->strQuery;
		
	}
	
}