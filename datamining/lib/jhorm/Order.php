<?php
/**
 * sql排序类
 * @author johnshwang
 *
 */
class Order{

	protected $SortType;
	protected $SortField;
	
	public function __construct($SortField,$SortType){
	
		$this->SortField = $SortField;
		$this->SortType = $SortType;

	}
	
	public static function desc($SortField){
		return new Order($SortField,'desc');
	}
	
	public static function asc($SortField){
		return new Order($SortField,'asc');
	}
	
	public function generateSQL(){
	
		switch($this->SortType){
			case 'desc':$sql = $this->SortField." DESC ";break;
			case 'asc' :$sql = $this->SortField." ASC ";break;
		}
		return $sql;
	
	}
}