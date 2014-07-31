<?php
class SinaWeiboEdgeJh extends DataBoundObject{
	
	public $ID;
	public $SinaUidS;
	public $SinaUidE;

/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("sina_weibo_edge_jh");
		// TODO Auto-generated method stub
	}

/* (non-PHPdoc)
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
		// TODO Auto-generated method stub
		return null;
			
	}
	
}
?>