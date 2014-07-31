<?php
class SinaWeiboNode extends DataBoundObject{
	
	public $ID;
	public $Name;
	public $ScreenName;
	public $Sex;
	public $Location;
	public $Userface;
	public $FollowersCount;
	public $FriendsCount;
	public $EachFansCount;
	public $StatusesCount;
	public $CTime;
	public $MTime;
/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("sina_weibo_node");
		// TODO Auto-generated method stub
	}

/* (non-PHPdoc)
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
		// TODO Auto-generated method stub
		return null;
			
	}
	
	public function autoSaveNode($info){
		
		$this->setID($info['id']);
		$this->setName($info['name']);
		$this->setScreenName($info['screen_name']);
		$this->setSex($info['gender']);
		$this->setLocation($info['location']);
		$this->setUserface($info['profile_image_url']);
		$this->setFollowersCount($info['followers_count']);
		$this->setFriendsCount($info['friends_count']);
		$this->setEachFansCount($info['bi_followers_count']);
		$this->setStatusesCount($info['statuses_count']);
		$this->setCTime(time());
		$this->Replace();
		
	}
	/**
	 * 分片处理
	 * @param int $sina_uid
	 */
	public function setID($sina_uid){
		$this->ID = $sina_uid;
		$this->arModifiedRelations['ID'] = "1";
		$this->strTableName = 'sina_weibo_node_mod5_cd'.(($sina_uid % 5)+1);
	}
}
?>