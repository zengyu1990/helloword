<?php
class SinaAppUseResult extends DataBoundObject{
	
	public $ID;
	public $AppIsbnId;
	public $UserId;
	public $IfShare;
	public $IfModifyWeibo;
	public $DefaultMentionsNode;
	public $LastMentionsNode;
	public $LastMentionsCount;
	public $AlgorithmMark;
	public $CTime;
/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("sina_app_use_result");
		// TODO Auto-generated method stub
	}

/* (non-PHPdoc)
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
		// TODO Auto-generated method stub
		return null;
			
	}
	
	/**
	 * @author johnshwang
	 * 扫描字符串'@xxx ',提取@的人
	 */
	public function detectAtPersonByMainContent($mc) { 
		$result = array ();
		$i = 0;
		$start = - 1;
		$end = - 1;
		$count = strlen ( $mc );
		while ( $i < $count ) {
			if ($mc [$i] == '@')
				$start = $i;
			if ((ord( $mc [$i] ) >= 32 && ord( $mc [$i] ) < 45) || (ord( $mc [$i] ) == 46 && ord( $mc [$i] ) == 47) || (ord( $mc [$i] ) >= 58 && ord( $mc [$i] ) <= 64) || (ord( $mc [$i] ) >= 91 && ord( $mc [$i] ) <= 94) || (ord( $mc [$i] ) == 96) || (ord( $mc [$i] ) >= 123 && ord( $mc [$i] ) <= 126))
				$end = $i;
			if ($start > 0 && $end > 0 && $start < $end ) {
				$result [] = substr ( $mc, $start , $end - $start );
				$start = - 1;
				$end = - 1;
			}
			if($end - $start > 30){
				$start = - 1;
				$end = - 1;
			}
			$i ++;
		}
		return $result;
// 		return implode(' ,',$result);
	}
	
}
?>