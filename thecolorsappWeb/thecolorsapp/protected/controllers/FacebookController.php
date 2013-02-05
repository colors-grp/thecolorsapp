<?php
/**
  * Facebook Controller is a class to controll all things related to facebook
  */
class FacebookController extends Controller
{
	/**
      * This method get name of user with specific ID
      *
      * @param string $id represent user id
      *
      * @return string
      */
	public static function getUserName($id)
	{
		$url = 'http://graph.facebook.com/'. urlencode($id);
		if(($id[0]!='U' && $id[0]!='u'))
		{
    		$pageContent = file_get_contents($url);
			$data  = json_decode($pageContent);
			return $data->name;
		}
		return $id;
	}
	/**
      * This method get id of logged in user
      *
      * @param 
      *
      * @return string
      */
	public static function getUserID()
	{
		return Yii::app()->facebook->getUser();
	}
	/**
      * This method get friends of user, it return array of facebookUser object
      *
      * @param 
      *
      * @return array of facebookUser
      */
	public static function getUserFriends()
	{
		$friends = Yii::app()->facebook->api('/me/friends');
		$listOfFriendsInColors = array();
		foreach($friends['data'] as $singleFriend)
		{
			$exist = User::model()->exists('fb_id=:fb_id',array(':fb_id'=>$singleFriend['id']));
			$facebookFriend = new FacebookUser();
			$facebookFriend->setData($exist,$singleFriend['name'],$singleFriend['id']);
			array_push($listOfFriendsInColors,$facebookFriend);
		}
		return $listOfFriendsInColors;
	}
	/**
      * This method update for each user friends it's rank and score in a given category name
      *
      * @param string $cat_name represent category name
	  * @param array $friendsGrid refernce variable to user friends   
      *
      * @return void
      */
	public static function getUserFriendsWithSingleCategoryRanks($cat_name,&$friendsGrid)
	{
		$res  = RankController::singleCategoryRanks($cat_name);
		for($i=0 ; $i<count($friendsGrid);$i++)
		{
			if($friendsGrid[$i]->isExist() == FALSE)
				continue;
			if(isset($res[$friendsGrid[$i]->getID()]))
			{
				$arr = &$res[$friendsGrid[$i]->getID()];
				$friendsGrid[$i]->addCategoryRank($arr['follow'],$arr['catName'],$arr['rankID'],$arr['score'],$arr['rankName']);
			}
			else
			{
				$friendsGrid[$i]->addCategoryRank(FALSE,$cat_name);
			}
		}
	}
	/**
      * This method assign for all user friends their rank and score in all categories
      *
	  * @param   
      *
      * @return array of facebookUser
      */
	public static function getUserFriendsWithAllCategoriesRanks()
	{
		$friendsGrid = FacebookController::getUserFriends();
		$cat_names = Category::model()->findAllBySql('SELECT cat_name FROM Category');
		 foreach($cat_names as $cat_name)
		 {
			FacebookController::getUserFriendsWithSingleCategoryRanks($cat_name->cat_name,$friendsGrid);
		 }
		 return $friendsGrid;
		
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