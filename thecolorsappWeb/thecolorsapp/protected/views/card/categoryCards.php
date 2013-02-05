<!-- <a href='index.php?r=marektPlace/showMarket&user_id=<?php echo $user_id;?>'> Back to market </a> -->
<div id="cards">
<?php
$cnt = 1;
for($i=0;$i<count($cards);$i++)
{
	$card = &$cards[$i]->card_id;
	$url = CController::createUrl('card/cardContent'). "&card_id=". $card. "&cat=". $cat_name;
	if($cardsUsed[$card]===NULL)
	{
		echo "<button id='card' type='button' onclick=". "location.href='$url'".">";
	}
	else
	{
		echo "<button id='card' type='button' onclick=". "location.href='$url'"." disabled>";
	}
	echo $cat_name. " (Card ". $cnt. ") (". $cards[$i]->card_points. " pts)";
	echo "</button>";
	$cnt++;
}
?>
</div> 