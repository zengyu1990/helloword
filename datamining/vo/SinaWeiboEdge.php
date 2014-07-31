<?php
class SinaWeiboEdge extends DataBoundObject{
	
	public $ID;
	public $SinaUidS;
	public $SinaUidE;

/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("sina_weibo_edge");
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
	 * 分片处理
	 * @param int $sina_uid
	 */
	public function setSinaUidS($sina_uid){
		$this->SinaUidS = $sina_uid;
		$this->arModifiedRelations['SinaUidS'] = "1";
		$this->strTableName = 'sina_weibo_edge_mod5_cd'.(($sina_uid % 5)+1);
	}
}
?>