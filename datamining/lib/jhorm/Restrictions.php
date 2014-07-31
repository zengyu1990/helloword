<?php
/**
 * 查询条件限制类
 * @author johnshwang
 *
 */
class Restrictions{

	protected $Type;
	protected $Field;
	protected $Value;
	
	public function __construct($Type,$Field,$Value){
	
		$this->Type  = $Type;
		$this->Field = $Field;
		$this->Value = $Value;

	}

	public function generateSQL(){
		
		switch($this->Type){
			case 'eq':$sql = $this->Field." = '".$this->Value."'";break;
			case 'ge':$sql = $this->Field." >= '".$this->Value."'";break;
			case 'le':$sql = $this->Field." <= '".$this->Value."'";break;
			case 'notEq':$sql = $this->Field." <> '".$this->Value."'";break;
			case 'like':$sql = $this->Field." LIKE '".$this->Value."'";break;
		}
		return $sql;
	}
	
	public static function eq($property,$value){
		return new Restrictions('eq',$property,$value);
// 		return array('Type'=>eq,'Property'=>$property,'Value'=>$value);
	}
	
	public static function notEq($property,$value){
		return new Restrictions('notEq',$property,$value);
	}
	
	public static function like($property,$value){
		return new Restrictions('like',$property,$value);
// 		return array('Type'=>like,'Property'=>$property,'Value'=>$value);
	}
	
	public static function in($property,$array_value){
		return new Restrictions('in',$property,$array_value);
// 		return array('Type'=>in,'Property'=>$property,'Value'=>$array_value);
	}
	
	public static function between($property,$min,$max){//[]
		return new Restrictions('between',$property,array('min'=>$min,'max'=>$max));
	}
	
	public static function gt($property,$value){//>
		return new Restrictions('gt',$property,$value);
	}
	
	public static function ge($property,$value){//>=
		return new Restrictions('ge',$property,$value);
	}
	
	public static function lt($property,$value){//<
		return new Restrictions('lt',$property,$value);
	}
	
	public static function le($property,$value){//<=
		return new Restrictions('le',$property,$value);
	}
}