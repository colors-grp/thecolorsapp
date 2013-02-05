<?php
/**
  * Transaction Controller is a class to controll all transactions which occur by user
  */
class TransactionController extends Controller
{
	/**
      * This method call transactions view to show all user transactions
      *
      * @param 
      *
      * @return void
      */
	public function actionTransactions()
	{
		if(FacebookController::getUserID() ==0)
		{
			$error = new ErrorController('error');
			$error->actionFaildUserID();
			return ;
		}
		$user_id = FacebookController::getUserID();
		$allTrans = Transaction::model()->findAll('fb_id=:fb_id ORDER BY dateTime DESC',array(':fb_id'=> $user_id));
		$this->render('transactions',array('user_id'=>$user_id,'allTrans'=>$allTrans));
	}
	/**
      * This method add new transaction
      *
      * @param string $id represent user id
      * @param string $type represent type of transaction
	  * @param int $cardID equal NULL by default
      * @return void
      */
	public static function addTransaction($id,$type,$cardID=NULL)
	{
		$trans = new Transaction;
		$trans->fb_id = $id;
		$trans->dateTime= date('Y-m-d H:i:s');
		$trans->trans_type= $type;
		if($cardID!=NULL)
			$trans->card_id = $cardID;
		$trans->save(); 
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