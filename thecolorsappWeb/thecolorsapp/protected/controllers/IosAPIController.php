<?php

class IosAPIController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionCheckUser()
	{
		$user_id = $_POST['user_id'];
		$user = User::model()->find('fb_id=:fb_id', array(':fb_id' => $user_id));
		if($user === NULL){
			$user = new User;
			$user->fb_id = $user_id;
			$user->purch_points =$this->get_default_points();
			$user->trading_points = $user->total_points = 0;
			$user->theme_name = 'regular';
			$user->type = 0;
			$user->save(); 
		}
	}
	protected function get_default_points(){
		$current = CurrentMetadata::model()->find('metadata_id=:metadata_id', array(':metadata_id' => 1 ));
		$metadata = Metadata::model()->find('metadata_id=:metadata_id', array(':metadata_id' => $current->metadata_id ));
		return $metadata->default_points;
	}
	public function actionRequestRanksForColor(){
		$cat_name = $_POST['cat_name'];
		$top_in_cat = Ranks::model()->findAll('cat_name=:cat_name', array(':cat_name' => $cat_name));
		$top_rank_names = $this->extract_rank_names($top_in_cat); //Gold, Silver, .. etc
		$cat_users = UserCategory::model()->findAll('cat_name=:cat_name', array(':cat_name' => $cat_name));
		$sorted_scores = array(); $users_map = array();
		$this->get_sorted_users($cat_users, $sorted_scores, $users_map); //last two are passed by ref and changed inside the function
		$ranks= array();
		/*
		{
			"topR":[{"rankName": , "score": , "users":[]}],
			"all":[ {"score": , "users:[]"}],
			"state":""
		} */
		$i = 0;
		$found = 0;
		$ranks["topR"] = array();
		foreach ($top_rank_names as $record) {
			if ($i >= count($sorted_scores))
				break;
			$arr = array();	
			$found = 1;
			//echo $record . ' => ';
			
			$score = $sorted_scores[$i];
			
			$users = &$users_map[$score];
			$comma = "";
			$usrs = array();
			$j=0;
			foreach ($users as $user) {
				//echo $comma . $user;
				//$comma = ", ";
				$usrs[$j]= $user;
				$j++;
			}
			$arr["rankName"] = $record ;
			$arr["score"] = $score;
			$arr["users"] = $usrs;
			$ranks["topR"][$i] = $arr;
			$i++;
			//echo '<br/>';
		}
		if ($found) {
			//Full Ranking Table
			$ranks["state"] = "yes";
			//echo '<br/><br/>Ranking Table <br/>';
			//echo '<table border="1">';
			$ranks["all"] = array();
			$i=0;
			foreach ($sorted_scores as $score) {
				$arr = array();
				$users = &$users_map[$score];
				$j=0;
				$usr = array();
				foreach ($users as $user) {
					//echo '<tr>';
					//echo '<td>' . $user . '</td>';
					//echo '<td>' . $score . '</td>';
					//echo '</tr>';
					$usr[$j] = $user;
					$j++;
				}
				$arr["score"] = $score;
				$arr["users"] =  $usr;
				$ranks["all"][$i]= $arr;
				$i++;
			}
			//echo '</table>';
		}
		else{
		$ranks["state"] = "no";
			//echo "No users registered in this color.";
		}
		$json = json_encode($ranks);
		echo $json;
	}
	
	//return list of rank names in a specific category (e.g. Gold, Silver, .. etc)
	private function extract_rank_names(&$top_in_cat)
	{
		
		$top_pairs = array(); //array to hold pairs of (rank, rank_name) like {(1, Gold), (2,Silver),..etc}
		foreach ($top_in_cat as $record) {
			$element = array($record->rank_priority, $record->rank_name);
			array_push($top_pairs, $element);			
		}
		sort($top_pairs);
		return UtilityController::get_kth_dimention($top_pairs, 1); //holds second element of pair only {Gold, Silver, .. etc};
	}
	
	//sorted_scores contains all scores, then users_map[score] get list of all users with that score
	private function get_sorted_users(&$cat_users, &$sorted_scores, &$users_map){
		foreach ($cat_users as $record) {
			if(array_key_exists($record->user_cat_score, $users_map) === FALSE){
				$users_map[$record->user_cat_score] = array();
				array_push($sorted_scores,$record->user_cat_score); 	
			}
			array_push($users_map[$record->user_cat_score], $record->fb_id);
		}
		rsort($sorted_scores);
	}
	public function actionRequestColorsRanks()
	{
		$category_rows = Category::model() -> findAll();
		$top_categories = array(); // pairs of (categ points, categ)
		foreach ($category_rows as $record) {
			array_push($top_categories, array($record -> cat_points, $record -> cat_name));
		}
		rsort($top_categories);
		$res= array('ranks'=>$top_categories);
		$json = json_encode($res);
		echo $json;
	}
	public function actionRequestUserPoints()
	{
		$user_id = $_POST['user_id'];
		$user = User::model()->find('fb_id=:fb_id',array(':fb_id'=>$user_id));
		$user_points = $user->getAttribute('purch_points');
		$res = array('points'=>$user_points);
		$json =  json_encode($res);
		echo $json;
	}
	public function actionPurchaseCard()
	{
		$user_id = $_POST['user_id'];
		$cat_name = $_POST['cat_name'];
		$card_id = $_POST['card_id'];
		$user = User::model()->find('fb_id=:fb_id',array(':fb_id'=>$user_id));
		$card = Card::model()->find('card_id=:card_id',array(':card_id'=>$card_id));
		$user_points = $user->getAttribute('purch_points');
		$card_points = $card->getAttribute('card_points');
		$uc = User_Card::model()->find('fb_id=:fb_id and card_id=:card_id',array(':card_id'=>$card_id,':fb_id'=>$user_id));
		$res = array();
		if($uc===NULL)
		{
			if(($card_points <= $user_points ))
			{
				
				
				$user_points-= $card_points;
				$total = $user->getAttribute('total_points');
				$total+= $card_points;
				$user->purch_points = $user_points;
				$user->total_points = $total;
				$user->save();
				
				$user_card = new User_Card;
				$user_card->fb_id = $user_id;
				$user_card->card_id = $card_id;
				$user_card->instance_number=0;
				$user_card->save();
				
				$catg = Categ::model()->find('cat_name=:cat_name',array('cat_name'=>$cat_name));
				$catg->cat_points = ($catg->cat_points+$card_points);
				$catg->save();
				/*$trans1 = new Transaction;
				$trans1->fb_id = $user_id;
				$trans1->dateTime= date('Y-m-d H:i:s');
				$trans1->trans_type="PURCHASE 1";
				$trans1->save(); */
				$trans = new Transaction;
				$trans->fb_id = $user_id;
				$trans->card_id = $card_id;
				$trans->dateTime= date('Y-m-d H:i:s');
				$trans->trans_type="BUY CARD";
				$trans->save(); 
				$res['msg']= "You are successfully purchase this card";
				
			}
			else
			{
				$res['msg']= "You don't have enough points to purchase this card";
			}
		}
		else
		{
			$res['msg']= "You already purchase this card before";
		} 
		$json = json_encode($res);
		echo $json;
	}
	public function actionRequestCardsByCategoryNameAndUserID()
	{
		$user_id = $_POST['user_id'];
		$cat_name = $_POST['cat_name'];
		$allCards = Card::model()->findAll('cat_name=:cat_name',array(':cat_name'=>$cat_name));
		//$allCardByUser = User_Card::model()->findAll('fb_id=:fb_id',array(':fb_id'=>$user_id));
		$res =array();
		$i=1;
		foreach($allCards as $singleCard)
		{
			$card = User_Card::model()->find('fb_id=:fb_id and card_id=:card_id',array(':fb_id'=>$user_id,':card_id'=>$singleCard->card_id));
			$cardName = "Card". $i;
			if($card === NULL)
			{
				$res[$cardName] = array('card_id'=>$singleCard->card_id,'card_points'=>$singleCard->card_points,'state'=>'no');
			}
			else
			{
				$res[$cardName] = array('card_id'=>$singleCard->card_id,'card_points'=>$singleCard->card_points,'state'=>'yes');
			}
			$i++;
		}
		$json = json_encode($res);
		echo $json;
	}
	public function actionRequestCategoriesFollowedByUser()
	{
		$user_id = $_POST['user_id'];
		$categByUser = User_Category::model()->findAll('fb_id=:fb_id',array(':fb_id'=>$user_id));
		$userCatg =  array();
		$i=0;
		foreach($categByUser as $singleCateg)
		{
			$userCatg[$i]=$singleCateg->cat_name;
			$i++;
		}
		$json = json_encode(array('categ'=>$userCatg));
		echo $json;
		
	}
	public function actionUpdateUserSettings()
	{
		$user_id = $_POST['user_id'];
		$json = $_POST['json'];
		$categories = json_decode($json);
		foreach($categories as $cat_name => $state)
		{
			$cat = User_Category::model()->find('fb_id=:fb_id and cat_name=:cat_name',array(':fb_id'=>$user_id,':cat_name'=>$cat_name));
			if($cat===NULL && $state=="yes")
			{
				$user_cat = new User_Category;
				$user_cat->fb_id = $user_id;
				$user_cat->cat_name = $cat_name;
				$user_cat->user_cat_score=0;
				$user_cat->save();
				$catg = Categ::model()->find('cat_name=:cat_name',array(':cat_name'=>$cat_name));
				$catg->cat_user_num = $catg->cat_user_num + 1;
				$catg->save();
				$trans = new Transaction;
				$trans->fb_id = $user_id;
				$trans->dateTime= date('Y-m-d H:i:s');
				$trans->trans_type= $cat_name. "_optin";
				$trans->save(); 
			}
		}
	}
	public function actionRequestCategoriesByUser()
	{
		/*$user_id =$_POST['user_id'];
		$test = array();
		$test['id1'] = $user_id;*/
		$user_id = $_POST['user_id'];
		//$test['id2'] = $user_id;
		$categByUser = User_Category::model()->findAll('fb_id=:fb_id',array(':fb_id'=>$user_id));
		$allCatg = Categ::model()->findAll();
		$resCateg = array();
		$userCatg =  array();
		foreach($categByUser as $singleCateg)
		{
			$userCatg[$singleCateg->cat_name]="yes";
		}
		foreach($allCatg as $singleCateg)
		{
			if(array_key_exists($singleCateg->cat_name,$userCatg))
			{
				$resCateg[$singleCateg->cat_name]="yes";
			}
			else
			{
				$resCateg[$singleCateg->cat_name]="no";
			}
		}
		
		$json = json_encode($resCateg);
			//$test['id3'] = count($categByUser);
	//	$json = json_encode($);
		echo $json;
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