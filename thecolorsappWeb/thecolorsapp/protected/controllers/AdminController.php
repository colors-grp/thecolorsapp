<?php
 /**
  * Admin Controller is a class to controller admin page and provide it with data
  */
class AdminController extends Controller
{
	/**
      * This method called by user main page (if admin) which call admin view page
      *
      * @param none.
      *
      * @return void
      */
	public function actionAdmin()
	{
		/** @type array of records contains all categories names */
		$allCat = Category::model()->findAllBySql('SELECT cat_name FROM Category');
		/** @type array of records contains all Points and their prices */
		$allBuy = Buy::model()->findAll();
		$this->render('admin',array('allCat'=>$allCat,'allBuy'=>$allBuy));
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