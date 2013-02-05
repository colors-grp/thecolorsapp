<?php
/* @var $this UserController */

for($i=0;$i<count($topCategories);$i++) {
	 $element = &$topCategories[$i];
	echo '<a href="index.php?r=rank/CategoryRanks&cat_name=' . $element[1]. '">' .
	 		sprintf("%s (%d)", $element[1], $element[0]) .
	  	 '</a><br/>';
}
?>
<script>
	function logoutFacebook() {
		$.ajax({
			url : "index.php?r=user/logout",
			success : function(result) {
				top.location.href = '<?php echo CController::createUrl("user/mainEntry")?>';		
			}
		});
		
	}
</script>
<br/><br/>
<a style="float:right;" href="javascript:logoutFacebook();" > Log Out </a>
<ul>
<?php
if ($admin==TRUE) {
	echo "<li> <a href=". "'http://colors-studios.com/thecolorsapp/index.php?r=admin/admin'". "'> Admin Page </a> </li>";
}
?>
<li> <a href="index.php?r=category/categories" > My Market </a> </li>
<li> <a href="index.php?r=user/settings" > My Settings </a> </li>
<li> <a href="index.php?r=transaction/transactions" > My Transactions </a> </li>
</ul>
<table>
<?php
$allCategories = array();
for($i=0;$i<count($topCategories);$i++)
{
	array_push($allCategories,$topCategories[$i][1]);
}
echo "<tr>";
echo "<th> </th>";
for($i =0 ;$i<count($allCategories) ; $i++)
{
	echo "<th>". $allCategories[$i]. "</th>";
}
echo "</tr>";
for($i=0;$i<count($friendsInColors);$i++)
{
	echo "<tr>";
	echo "<td>". $friendsInColors[$i]->getName(). "</td>";
	for($j =0 ;$j<count($allCategories) ; $j++)
	{
		echo "<td>";
		$rankID = $friendsInColors[$i]->getRankForCategory($allCategories[$j]);
		if($rankID==0)
		{
			echo "<a href=''> Invite to This COLOR</a>";
		}
		else
		{
			echo $rankID;
		}
		echo "</td>";
	}
	echo "</tr>";
}
echo "</table>";
echo "<table>";
echo "<tr>";
echo "<th> </th>";
for($i =0 ;$i<count($allCategories) ; $i++)
{
	echo "<th>". $allCategories[$i]. "</th>";
}
echo "</tr>";
for($i=0;$i<count($friendsNotInColors);$i++)
{
	echo "<tr>";
	echo "<td>". $friendsNotInColors[$i]->getName(). "</td>";
	for($j =0 ;$j<count($allCategories) ; $j++)
	{
		echo "<td>";
		echo "<a href=''> Invite to COLORS APP</a>";
		echo "</td>";
	}
	echo "</tr>";
}
?>
</table>