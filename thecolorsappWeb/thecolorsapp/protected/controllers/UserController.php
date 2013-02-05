<?php
/**
  * user Controller is a class to controll all operation by user
  */
class UserController extends Controller
{
	/**
      * This method used to add points to user
      *
      * @param string $id represent user id
      * @param int $pts represent points to be added
	  *
      * @return void
      */
	public static function addPointsToUser($id,$pts)
	{
		$user = User::model()->find('fb_id=:fb_id', array(':fb_id'=>$id));
		$user->purch_points = ($user->purch_points+$pts);
		$user->save();	
	}
	/**
      * This method called when user buy a card to add points of card to user category so that rank table can be updated.
      *
      * @param string $id represent user id
      * @param int $pts represent card points to be added
	  * @param string $catName represent category name
	  * 
      * @return void
      */
	public static function addPointsToUserCategory($id,$catName,$pts)
	{
		$ucat = UserCategory::model()->find('fb_id=:fb_id and cat_name=:cat_name',array(':fb_id'=>$id, ':cat_name'=>$catName));
		$ucat->user_cat_score = ($ucat->user_cat_score+$pts);
		$ucat->save();
		
	}
	/**
      * This method called when user buy a card to add this card to user.
      *
      * @param string $id represent user id
      * @param int cCardID represent card id
	  * 
      * @return void
      */
	public static function addNewUserCard($id,$cardID)
	{
		$user_card = new UserCard;
		$user_card->fb_id = $id;
		$user_card->card_id = $cardID;
		$user_card->instance_number=0;
		$user_card->save();
		
	}
	/**
      * This method called when user buy a card subtract card points from user purchase points and to add them to user total points.
      *
      * @param string $id represent user id
      * @param int $pts represent points to subtract
	  * 
      * @return void
      */
	public static function decreasePoints($id,$pts)
	{
		$user = User::model()->find('fb_id=:fb_id',array(':fb_id'=>$id));
		$user->purch_points = ($user->purch_points-$pts);
		$user->total_points = ($user->total_points+$pts);
		$user->save();
	}
	/**
      * This method called when user follow category.
      *
      * @param string $id represent user id
      * @param string $catName represent category name
	  * 
      * @return void
      */
	public function addUserCategory($id,$cat_name)
	{
		$user = new UserCategory;
		$user->fb_id = $id;
		$user->cat_name = $cat_name;
		$user->user_cat_score=0;
		$user->save();
	}
	 /** This method called to render setting view so that user can follow new categories.
      *
      * @param 
	  * 
      * @return void
      */
	public function actionSettings()
	{
		if(FacebookController::getUserID() ==0)
		{
			$error = new ErrorController('error');
			$error->actionFaildUserID();
			return ;
		}
		$user_id = FacebookController::getUserID() ;
		$allCateg = Category::model()->findAllBySql('SELECT cat_name FROM Category');
		$followed = UserCategory::model()->findAll('fb_id=:fb_id',array('fb_id'=>$user_id));
		$followedCategory = array();
		foreach($followed as $catg)
		{
			$followedCategory[$catg->getAttribute('cat_name')]=true;
		}
		$this->render('settings',array('user_id'=>$_GET['user_id'],'allCateg'=>$allCateg,'followedCategory'=>$followedCategory));
	}
	/** This method called to save user settings
	  * 
      * @param string $id represent user id through GET
	  * @param string $cat_name represent category name through GET
	  * 
      * @return void
      */
	public function actionSave()
	{
		$cat_name = $_GET["cat_name"];
		$state = $_GET["state"];
		$id = $_GET['user_id'];
		$find = UserCategory::model()->find('fb_id=:fb_id and cat_name=:cat_name',array(':fb_id'=>$id,':cat_name'=>$cat_name));
		if($find===NULL)
		{
			if($state==1)
			{
				$this->addUserCategory($id, $cat_name);
				CategoryController::addUserToCategory($cat_name);
				TransactionController::addTransaction($id,($cat_name. "_optin"));
			}
		}
	}
	/** This method check if new user or not , and if new user put him in database with default points , aslo check if admin,it
	  * returns BOOL true if admin else false 
	  * 
      * @param 
	  * 
      * @return bool
      */
	public function checkUser($userID)
	{
		$user = User::model()->find('fb_id=:fb_id', array(':fb_id' => $userID)); // select user with fbID
		if($user === NULL)
		{
			$user = new User;
			$user->fb_id = $userID;
			$user->purch_points =$this->getDefaultPoints();
			$user->trading_points = $user->total_points = 0;
			$user->theme_name = 'regular';
			$user->type = 0; // not admin
			$user->save(); 
			return FALSE;
		}
		if($user->type==0)
			return FALSE;
		return TRUE;
	}
	/** This method return default points to new user
	  * 
      * @param
	  * 
      * @return int
      */
	public function getDefaultPoints()
	{
		$current = CurrentMetadata::model()->find('metadata_id=:metadata_id', array(':metadata_id' => 1 ));
		$metadata = Metadata::model()->find('metadata_id=:metadata_id', array(':metadata_id' => $current->metadata_id ));
		return $metadata->default_points;
	}
	/** This method called when user logout
	  * 
      * @param
	  * 
      * @return void
      */
	public function actionLogout()
	{
		Yii::app()->facebook->destroySession();
	}
	/** This method determine which view to call depend on if user logged in or not
	  * 
      * @param
	  * 
      * @return void
      */
	public function actionMainEntry()
	{
		$userID = FacebookController::getUserID(); // get user facebook ID
		if($userID>0)
		{
			// user is logged in 
			$this->actionHomeWithLogin();	
		}
		else 
		{
			//user not logged in
			$this->actionHomeWithoutLogin();
		}
	}
	/** This method show view when user is logged in
	  * 
      * @param
	  * 
      * @return void
      */
	public function actionHomeWithLogin()
	{
		$userID = FacebookController::getUserID();
		$admin = $this->checkUser($userID);
		$topCategories = RankController::allCategoriesSorted();
		$friendsGrid = FacebookController::getUserFriendsWithAllCategoriesRanks(); 
		$friendsInColors = array();
		$friendsNotInColors = array();
		for($i=0;$i<count($friendsGrid);$i++)
		{
				if($friendsGrid[$i]->isExist()==FALSE)
					array_push($friendsNotInColors,$friendsGrid[$i]);
				else
					array_push($friendsInColors,$friendsGrid[$i]);
					
		}
		$this->render('homeWithLogin',array('userID'=>$userID,'topCategories'=>$topCategories,'admin'=>$admin,'friendsInColors'=>$friendsInColors,'friendsNotInColors'=>$friendsNotInColors));
	}
	/** This method show view when user is not logged in
	  * 
      * @param
	  * 
      * @return void
      */
	public function actionHomeWithoutLogin()
	{
		$topCategories = RankController::allCategoriesSorted();
		$this->render('homeWithoutLogin',array('topCategories'=>$topCategories));
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