<?php
/**
  * Card Controller is a class to manage all card operation and views
  */
class CardController extends Controller
{
	/**
      * This method called when user clicked on specific card in category, it's generate card content (images) and call cardContent View 
      * to display this card
	  * 
      * @param int $card_id sent through GET represent card id
	  * @param string $cat_name sent through GET represent category name which the given card in it 
      *
      * @return void
      */
	public function actionCardContent()
	{
		if(FacebookController::getUserID() ==0)
		{
			$error = new ErrorController('error');
			$error->actionFaildUserID();
			return ;
		}
		$card_id = $_GET["card_id"];
		$user_id = FacebookController::getUserID();
		$cat_name = $_GET["cat"];
		// To be Change
		$num = $card_id % 7 ;
		$num++;
		$picName = array("nancyCompBG", "nancyfbCover","nancyfbPP","nancymobileBG");
		// end change
	    /** @type string represent card's images urls */		
		$picURL = array();
		for ($i=0 ; $i <count($picName) ; $i++)
		{
			$picURL[$i] = UtilityController::siteUrl(). $num. "/". $picName[$i]. ".jpg";
		}
		/** @type string represent card's css elements  */
		$cssName = array("compBG", "fbCover","fbPP","mobileBG");
		$this->render('cardContent',array('card_id'=>$card_id,'user_id'=>$user_id,'cat_name'=>$cat_name,'picURL'=>$picURL,'cssName'=>$cssName));
	}
	  /**
      * This method called when user click on specific category, it's generate all cards belong to this category and call categoryCards
      *	view to display all cards
	  * 
      * @param string $cat_name through GET which represent name of the given category
      *
      * @return void
      */
	public function actionCategoryCards()
	{
		if(FacebookController::getUserID() ==0)
		{
			$error = new ErrorController('error');
			$error->actionFaildUserID();
			return ;
		}
		
		$user_id = FacebookController::getUserID();
		$cat_name = $_GET['catg'];
		$cards = Card::model()->findAll('cat_name=:cat_name',array('cat_name'=>$cat_name));
		$userCards = UserCard::model()->findAll('fb_id=:fb_id',array('fb_id'=>$user_id)); 
		$cardsUsed = array();
		for($i=0;$i<count($userCards);$i++)
		{
			$card = &$userCards[$i]->card_id ;
			$cardsUsed[$card] = true;
		}
		$this->render('categoryCards',array('user_id'=>$user_id,'cat_name'=>$cat_name,'cards'=>$cards,'cardsUsed'=>$cardsUsed));
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