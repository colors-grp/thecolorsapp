<?php
/* @var $this TransactionController */

$this->breadcrumbs=array(
	'Transaction'=>array('/transaction'),
	'Transactions',
);
?>
<!--<a href='index.php?r=site/index&user_id=<?php echo $user_id; ?>'> Home </a>-->
<table border="3px">
<tr>
<th id="transHeader"> Action</th>
<th id="transHeader"> Card_ID</th>
<th id="transHeader"> Category_Name</th>
<th id="transHeader"> Points </th>
<th id="transHeader"> Date </th>
</tr>
<?php
for($i=0;$i<count($allTrans);$i++)
{
	$singleTrans = &$allTrans[$i];
	$card_id= $singleTrans->getAttribute('card_id');
	echo "<tr>";
	echo "<td>". $singleTrans->getAttribute('trans_type'). "</td>";
	if($card_id===NULL)
	{
		echo "<td>". "NULL". "</td>";
		echo "<td>".  "NULL". "</td>";
		echo "<td>".  "NULL". "</td>";
	}
	else {
		echo "<td>". $card_id. "</td>";
		$card = Card::model()->find('card_id=:card_id',array(':card_id'=>$card_id));
		echo "<td>". $card->getAttribute('cat_name'). "</td>";
		echo "<td>". $card->getAttribute('card_points'). "</td>";
		
	}
	$date = $singleTrans->getAttribute('dateTime');
	echo "<td>". $date. "</td>";
	echo "</tr>";
}
?>
</table>