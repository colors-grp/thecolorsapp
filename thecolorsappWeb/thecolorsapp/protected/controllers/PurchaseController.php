<?php
/**
  * Purchase Controller is a class to manage all stuff related to buying and points
  */
class PurchaseController extends Controller
{
	/**
      * This method called from admin page to add new package with points and their price
      *
      * @param int $buy_points through GET represent package points
	  * @param int $buy_price through GET represent package price 
      *
      * @return void
      */
	public function actionAddBuy()
	{
		$buy_points = $_GET['buy_points'];
		$buy_price = $_GET['buy_price'];
		$buy = new Buy;
		$buy->buy_points = $buy_points;
		$buy->buy_price = $buy_price;
		$buy->save();
	}
	/**
      * This method called when user purchase card, it's check if user can buy this card or not and return one of the following result
      * "You don't have enough points to purchase this card","You are successfully purchase this card",
	  * "You already purchase this card before"
	  * 
      * @param string $user_id through GET represent user id
	  * @param int $card_id through GET represent card id which will be bought 
      * @param string $cat_name through GET represent category name
	  * 
      * @return string
      */
	public function actionPurchase()
	{
		
		$user_id =  $_GET['user_id'];
		$card_id = $_GET['card_id'];
		$cat_name =  $_GET['cat_name'];
		$user = User::model()->find('fb_id=:fb_id',array(':fb_id'=>$user_id));
		$card = Card::model()->find('card_id=:card_id',array(':card_id'=>$card_id));
		$user_points = $user->getAttribute('purch_points');
		$card_points = $card->getAttribute('card_points');
		$uc = UserCard::model()->find('fb_id=:fb_id and card_id=:card_id',array(':card_id'=>$card_id,':fb_id'=>$user_id));
		if($uc===NULL)
		{
			if(($card_points <= $user_points ))
			{
				UserController::decreasePoints($user_id,$card_points);
				UserController::addPointsToUserCategory($user_id,$cat_name,$card_points);				
				CategoryController::addPointsToCategory($cat_name,$card_points);				
				TransactionController::addTransaction($user_id,"BUY Card",$card_id);
				UserController::addNewUserCard($user_id,$card_id);
				echo "You are successfully purchase this card";
				
			}
			else
			{
				echo "You don't have enough points to purchase this card";
			}
		}
		else
		{
			echo "You already purchase this card before";
		} 
	}
    /**
      * This method called when user want to buy points it get all available package sorted by price and display view with them
	  * 
      * @param 
	  * 
      * @return void
      */
    public function actionBuyPoints()
    {
        $rows = Buy::model() -> findAllBySql('SELECT * FROM Buy ORDER BY buy_price ASC');
		$packs = array();
		for ($i=0;$i<count($rows);$i++) {
			array_push($packs, array($rows[$i] -> buy_points, $rows[$i] -> buy_price));
		}
		$this -> render('buyPoints', array('packs' => $packs));
    }
    /**
      * This method called when user commit to buy package points and return sucess or fail (if user doesn't have enough money)
	  * 
      * @param int $points through GET represent points user will buy
	  * 
      * @return string
      */
    public function actionCommit() {
		$points = $_GET['points'];
		$fb_id = FacebookController::getUserID();
		UserController::addPointsToUser($fb_id,$points);
		TransactionController::addTransaction($fb_id,"Purchase ". $points);
		echo "Purchase done successfully";
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