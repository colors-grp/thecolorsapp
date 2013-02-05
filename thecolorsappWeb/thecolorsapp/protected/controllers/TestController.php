<?php

class TestController extends Controller
{
	public function	actionIndex()
	{
		$id = FacebookController::getUserID();
		if($id>0){
		$friendsGrid = FacebookController::getUserFriendsWithAllCategoriesRanks(); 
		}
		else
			{
				header(Yii::app()->facebook->getLoginUrl());
			}
		//$this->render('index');
	}
}
?>


