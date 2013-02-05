<?php
$cat_name = $_GET['catg'];
$data = Card::model()->findAll('cat_name=:cat_name',array('cat_name'=>$cat_name));
$cnt = 1;
foreach($data as $record)
{
	$card = $record->getAttribute("card_id") ;
	$url = "index.php?r=marektPlace/showCard&card_id=". $card;
	echo "<button id='card' type='button' onclick=". "location.href='$url'".">";
	echo "Card". $cnt;
	echo "</button>";
	$cnt++;
}
?>