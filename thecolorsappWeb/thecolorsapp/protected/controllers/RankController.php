<?php
/**
  * Rank Controller is a class to manage ranking tables for users and categories
  */
class RankController extends Controller
{
	public  $catName;
	/**
      * This method print table with current ranks in category , it called from admin page.
      *
      * @param string $cat_name represent category name it sent through GET
      *
      * @return void
      */
	public function actionCategoryRanksNames()
	{
		$cat_name = $_GET['catg_name'];
		$ranks =  Ranks::model()->findAll('cat_name=:cat_name',array(':cat_name'=>$cat_name));
		echo "<table>";
			echo "<tr>";
				echo "<th> Rank Name </th>";
				echo "<th> Rank Priority </th>";
			echo "</tr>";
		for($i=0;$i<count($ranks);$i++)
		{
			echo "<tr>";
				echo "<td>". $ranks[$i]->rank_name. "</td>";
				echo "<td>". $ranks[$i]->rank_priority. "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	/**
      * This method add new rank to category, it called from admin page
      *
      * @param string $cat_name represent category name it sent through GET
      * @param string $rank_name represent new rank name it sent through GET
	  * @param int $rank_pr represent new rank priority it sent through GET
	  * 
      * @return void
      */
	public function actionAddRank()
	{
		$catg_name = $_GET['catg_name'];
		$rank_name = $_GET['rank_name'];
		$rank_pr = $_GET['rank_pr'];
		$rank = new Ranks;
		$rank->rank_name = $rank_name;
		$rank->cat_name = $catg_name;
		$rank->rank_priority = $rank_pr;
		$rank->save();
	}
	
	/**
      * This method construct array of facebookUser repesents user's ranking in a given category sorted with score, aslo
      * it's assign for each user rank name if he/she in top users (i.e user1 is Gold in category X)
	  * 
      * @param string $catName represent category name it sent through GET
	  * 
      * @return array of facebookUser
      */
	public static function rankingForCategory($catName)
	{
		// make sql query to get all ranks name from ranks table sorted by priorirt
		$topRanksSql = 'SELECT rank_name FROM Ranks WHERE cat_name=\''. $catName. '\' ORDER BY rank_priority ASC';
		$topRanksNames = Ranks::model()->findAllBySql($topRanksSql);
		//select all users in category sorted by score
		$catUsersSql = 'SELECT fb_id,user_cat_score FROM User_Category WHERE cat_name=\''. $catName. '\' ORDER BY user_cat_score DESC';
		$catUsers = UserCategory::model()->findAllBySql($catUsersSql);
		
		$idx=0; // index on $catUsers array
		$rankID=1; // show current rank for user (maybe more than one user have same rankID)
		$UsersRanks = array(); // returned array 
		for($i=0;$i<count($topRanksNames);$i++)
		{
			// loop through all ranks names and find users who belong to this rank name
			if($idx>=count($catUsers))
				break;
			// $prevScore contains last user score who is belong to current rank name
			$prevScore = $catUsers[$idx]->user_cat_score;
			// this loop to group all users with the same score 
			while ($idx<count($catUsers) && $catUsers[$idx]->user_cat_score==$prevScore) {
				$facebookUser = new FacebookUser();
				$facebookUser->setData(TRUE,'none',$catUsers[$idx]->fb_id);
				$facebookUser->addCategoryRank(TRUE,$catName,$rankID,$catUsers[$idx]->user_cat_score,$topRanksNames[$i]->rank_name);
				array_push($UsersRanks,$facebookUser);
				$idx++;
			}
			$rankID++;
		}
		// all remaing users from $idx till the end of the array are normal users (not top users)
		while ($idx<count($catUsers) )
		{
			$prevScore = $catUsers[$idx]->user_cat_score;
			while ($idx<count($catUsers) && $catUsers[$idx]->user_cat_score==$prevScore) {
				$facebookUser = new FacebookUser();
				$facebookUser->setData(TRUE,'none',$catUsers[$idx]->fb_id);
				$facebookUser->addCategoryRank(TRUE,$catName,$rankID,$catUsers[$idx]->user_cat_score);
				array_push($UsersRanks,$facebookUser);
				$idx++;
			}
			$rankID++;
		}
		return $UsersRanks;
	}
	/**
      * This method construct hash map key is userID and value is array contain score , rank and rank name
	  * 
      * @param string $cat_name represent category name
	  * 
      * @return hash map (associative array )
      */
	public static function singleCategoryRanks($cat_name)
	{
		$UsersRanks = RankController::rankingForCategory($cat_name);
		$allUsers=  array();
		for ($i=0; $i < count($UsersRanks); $i++) {
			$ur = $UsersRanks[$i]->getCategory($cat_name); 
			$allUsers[$UsersRanks[$i]->getID()] = array('score' => $ur->getScore() ,'rankName'=> $ur->getRankName(), 'rankID'=> $ur->getRankID(),'catName' => $ur->getCatName(), 'follow'=>$ur->getFollow()); 
		}
		return $allUsers;
	}
	
	public function cmp($a,$b)
	{
		$aR=intval($a->getRankForCategory($this->catName));
		$bR=intval($b->getRankForCategory($this->catName));
		if($aR==$bR)
			return 0;
		return ($aR<$bR ? -1 : 1);
	}
	/**
      * This method call categoryRanks view providing it with all users ranks in given category also top user and finally ranks of
	  * user's friends (if logged in) 
	  * 
      * @param string $cat_name represent category name it sent through GET
	  * 
      * @return void
      */
	public function actionCategoryRanks()
	{
		$cat_name = $_GET['cat_name'];
		$this->catName = $cat_name;
		$usersRanking = $this->rankingForCategory($cat_name);
		// construct top user array
		$topUsers = array();
		for($i=0;$i<count($usersRanking);$i++)
		{
			if($usersRanking[$i]->getRankNameForCategory($cat_name)!=="none")
			{
				if(!isset($topUsers[$usersRanking[$i]->getRankNameForCategory($cat_name)]))
				{
					$topUsers[$usersRanking[$i]->getRankNameForCategory($cat_name)]= array();
				}
				array_push($topUsers[$usersRanking[$i]->getRankNameForCategory($cat_name)],$usersRanking[$i]);
			}
		}
		$friendsGrid = array();
		$userLoggedIn = FALSE;
		
		if(FacebookController::getUserID()>0)
		{
			$userLoggedIn = TRUE;
			$friendsGrid1= FacebookController::getUserFriends();
			$fbUsrs = new FacebookUser();
			$fbUsrs->setData(TRUE,'none',FacebookController::getUserID());
			array_push($friendsGrid1,$fbUsrs);
			FacebookController::getUserFriendsWithSingleCategoryRanks($cat_name,$friendsGrid1);
			for($i=0;$i<count($friendsGrid1);$i++)
			{
				if($friendsGrid1[$i]->isExist() ==TRUE && $friendsGrid1[$i]->isFollowCategory($cat_name)==TRUE)
				{
					array_push($friendsGrid, $friendsGrid1[$i]);
				}
			}
			echo count($friendsGrid);
			usort($friendsGrid,array("RankController","cmp"));
		}
		$topRanksSql = 'SELECT rank_name FROM Ranks WHERE cat_name=\''. $cat_name. '\' ORDER BY rank_priority ASC';
		$topRanksNames = Ranks::model()->findAllBySql($topRanksSql);
		$RankNames  = array();
		for($i=0;$i<count($topRanksNames);$i++)
			array_push($RankNames,$topRanksNames[$i]->rank_name);
		$this->render('categoryRanks', array('RankNames'=>$RankNames,'cat_name' => $cat_name, 'topUsers'=> $topUsers, 'usersRanking' => $usersRanking,'friendsGrid'=>$friendsGrid,'userLoggedIn'=>$userLoggedIn));
	}
	/**
      * This method return array of categories sorted by score
	  * 
      * @param 
	  * 
      * @return array
      */
	public static function allCategoriesSorted()
	{
		$categoryRows = Category::model() -> findAll();
		$topCategories = array(); // pairs of (categ points, categ)
		foreach ($categoryRows as $record) {
			array_push($topCategories, array($record -> cat_points, $record -> cat_name));
		}
		rsort($topCategories);
		return $topCategories;
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
?>