<?php
class SinaWeiboNodeJh extends DataBoundObject{
	
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
	public $Layer;
	public $CTime;
	public $MTime;
/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("sina_weibo_node_jh");
		// TODO Auto-generated method stub
	}

/* (non-PHPdoc)
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
		// TODO Auto-generated method stub
		return null;
			
	}
	
	public function autoSaveNode($info,$Layer){
		
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
		$this->setLayer($Layer);
		$this->Replace();
		
	}
}
?>