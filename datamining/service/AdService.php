<?php
class AdService extends ServiceObject{
/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("ad");
		// TODO Auto-generated method stub
	}

/* (non-PHPdoc)
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
		// TODO Auto-generated method stub
		return(array(
			"id"=>"ID",
			"name"=>"Name",
			"img_url"=>"ImgUrl",
			"content"=>"Content",
			"url"=>"Url",
			"pv_times"=>"PvTimes",
			"click_times"=>"ClickTimes",
			"c_time"=>"CTime",
			"m_time"=>"MTime",
		));
	}
/* (non-PHPdoc)
	 * @see ServiceObject::DefinePersistenceFactory()
	 */
	protected function DefinePersistenceFactory() {
		require_once JHORM_VO_FACTORY_DIR.'AdFactory.php';
		return (new AdFactory());
		// TODO Auto-generated method stub
	}
	
	public function getObjectByIsbn($isbn){
		$dsql = $this->createDetachedSQL();
		$dsql->add(Restrictions::eq('isbn',$isbn));
		$obj = $this->findByDetachedSQL($dsql);
		return $obj;
	}
}