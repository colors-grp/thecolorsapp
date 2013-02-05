<?php
class UserRank
{
	private $score;
	private $rankName;
	private $rankID;
	private $catName;
	private $follow;
	function __construct() 
	{
	}
	public function setData($score,$rankName,$rankID,$catName,$follow)
	{
		$this->score= $score;
		$this->rankName = $rankName;
		$this->rankID = $rankID;
		$this->catName = $catName;
		$this->follow = $follow;
	}
	public function getScore()
	{
		return $this->score;
	}
	public function getRankID()
	{
		return $this->rankID;
	}
	public function getRankName()
	{
		return $this->rankName;
	}
	public function getCatName()
	{
		return $this->catName;
	}
	public function getFollow()
	{
		return $this->follow;	
	}
}
?>