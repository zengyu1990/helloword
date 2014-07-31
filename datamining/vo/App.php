<?php
class App extends DataBoundObject{
	
	public $ID;
	public $Akey;
	public $Skey;
	public $Apptype;
	public $Appname;
	public $Appinfo;
	public $TitleImg;
	public $Appurl;
	public $Svnurl;
	public $IsRecommend;
	public $Recommendytpe;
	public $Version;
	public $Audit;
	public $Square;
	public $Platform;
	public $Openweiboaccount;
	public $Saeaccount;
	public $Regdatetime;
	public $Lastmodifytime;
	public $Isbn;
	public $ChannelId;
	public $AppCustomType;
/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("app");
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