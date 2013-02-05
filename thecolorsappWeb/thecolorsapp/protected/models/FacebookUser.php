<?php
class FacebookUser
{
	private $exist;
	private $name;
	private $ID;
	private $categoriesRanks;
	function __construct() 
	{
		$categoriesRanks = array();
	}
	public function setData($exist,$name,$ID)
	{
		$this->exist= $exist;
		$this->name= $name;
		$this->ID= $ID;
	}
	public function addCategoryRank($followColor,$catName, $rankID=0, $score=0,$rankName='none')
	{
		$userRank = new UserRank();
		$userRank->setData($score,$rankName,$rankID,$catName,$followColor);
		$this->categoriesRanks[$catName] = $userRank;
		
	}
	public function addCategory($catName,$userRank)
	{
		$this->categoriesRanks[$catName] = $userRank;
		
	}
	public function getRankForCategory($catName)
	{
		return $this->categoriesRanks[$catName]->getRankID();
		//return $this->categoriesRanks[$catName]->getRankID();
	}
	public function getScoreForCategory($catName)
	{
		return $this->categoriesRanks[$catName]->getScore();
	}
	public function getRankNameForCategory($catName)
	{
		return $this->categoriesRanks[$catName]->getRankName();
	}
	public function getCategory($catName)
	{
		return $this->categoriesRanks[$catName];
	}
	public function getName()
	{
		if($this->name=='none')
			$this->name= FacebookController::getUserName($this->ID);
		return $this->name;
	}
	public function isExist()
	{
		return $this->exist;
	}
	public function getID()
	{
		return $this->ID;
	}
	public function isFollowCategory($catName)
	{
		return $this->categoriesRanks[$catName]->getFollow();
	}
}
?>