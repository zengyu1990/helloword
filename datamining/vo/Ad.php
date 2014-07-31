<?php
class Ad extends DataBoundObject{
	
	public $ID;
	public $Name;
	public $ImgUrl;
	public $Content;
	public $Url;
	public $PvTimes;
	public $ClickTimes;
	public $Isbn;
	public $CTime;
	public $MTime;
	
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
}
?>