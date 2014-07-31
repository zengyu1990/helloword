<?php
class SinaAppUserMapping extends DataBoundObject{
	
	public $ID;
	public $AppIsbnId;
	public $SinaUid;
	public $CTime;
	
/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("sina_app_user_mapping");
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