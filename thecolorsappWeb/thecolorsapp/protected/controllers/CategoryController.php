<?php
	/**
  	* Category Controller is a class used to controll all category operations and it's views
  	*/
class CategoryController extends Controller
{
	/**
      * This method called when user purchase card, it's add the card's points to category score
      *
      * @param string $catName represent category name
      * @param int $pts represent card's points
	  * 
      * @return void
      */
	public static function addPointsToCategory($catName,$pts)
	{
		$catg = Category::model()->find('cat_name=:cat_name',array('cat_name'=>$catName));
		$catg->cat_points = ($catg->cat_points+$pts);
		$catg->save();
	}
	/**
      * This method called when admin add new category to system
      *
      * @param string $catg_name through GET represent category name 
      * @param string $rank_eq through GET represent category equation used to calculate score  
	  * 
      * @return void
      */
	public function actionAddCategory()
	{
		$catg_name = $_GET['catg_name'];
		//$rank_eq= $_GET['rank_eq'];
		$catg = new Category;
		$catg->cat_name = $catg_name;
		$catg->save();
	}
	/**
      * This method called when user follow new category
      *
      * @param string $cat_name represent category name
      *
      * @return void
      */
	public static function addUserToCategory($cat_name)
	{
		$catg = Category::model()->find('cat_name=:cat_name',array(':cat_name'=>$cat_name));
		$catg->cat_user_num = $catg->cat_user_num + 1;
		$catg->save();
	}
	
	/**
      * This method called when user enter his market,it's generate categories followed by user
      *
      * @param 
      *
      * @return void
      */
	public function actionCategories()
	{
		if(FacebookController::getUserID() ==0)
		{
			$error = new ErrorController('error');
			$error->actionFaildUserID();
			return ;
		}
		
		$id  = FacebookController::getUserID();
		$userCategories = UserCategory::model()->findAll('fb_id=:fb_id',array('fb_id'=>$id));
		$data = User::model()->find('fb_id=:fb_id',array('fb_id'=>$id));
		$userPoints = $data->purch_points;
		$this->render('categories',array('id'=>$id,'userCategories'=>$userCategories,'userPoints'=>$userPoints));
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