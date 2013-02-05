<?php

echo $cat_name . '</br><br/>';

//Winners Table
for($i=0;$i<count($RankNames);$i++)
{
	$rankName = &$RankNames[$i];
	echo $rankName. ' => ';
	if(isset($topUsers[$rankName]))
	{
		$topRank = &$topUsers[$rankName];
		$comma = "";
		for($j=0;$j<count($topRank);$j++)
		{
			echo $comma . $topRank[$j]->getName();
			$comma = ", ";
		}
	}
	echo '<br/>';
}
?>
<script>
$(document).ready(function(){
	$('#allRanksTable').show();
	$('#myFriendsRanksTable').hide();
	$('#allRanks').click(function(){
		$('#allRanksTable').show();
	$('#myFriendsRanksTable').hide();
	});	
	$('#myFriends').click(function(){
		$('#allRanksTable').hide();
	$('#myFriendsRanksTable').show();	
	});
});
</script>
<?php
if($userLoggedIn==TRUE)
{
	echo "<button type='button' id='allRanks'> All Ranks </button>";
	echo "<button type='button' id='myFriends'> My Friends </button>";
}
?>
<br/><br/>Ranking Table <br/>
<div id="myFriendsRanksTable">
<?php
if (count($friendsGrid)) {
	//Full Ranking Table
	echo '<table border="1">';
	for($i=0 ;$i<count($friendsGrid);$i++) {
		
			echo '<tr>';
			echo '<td>' . $friendsGrid[$i]->getName() . '</td>';
			echo '<td>' . $friendsGrid[$i]->getScoreForCategory($cat_name) . '</td>';
			echo '<td>' . $friendsGrid[$i]->getRankForCategory($cat_name). '</td>';
			echo '</tr>';
	}
	echo '</table>';
}
else
	echo "No users registered in this color.";
?>
</div>
<div id="allRanksTable">
<?php
if (count($usersRanking)) {
	//Full Ranking Table
	echo '<table border="1">';
	for($i=0;$i<count($usersRanking);$i++)
	{
		$user = &$usersRanking[$i];
		echo '<tr>';
		echo '<td>' . $user->getName(). '</td>';
		echo '<td>' . $user->getScoreForCategory($cat_name). '</td>';
		echo '<td>' . $user->getRankForCategory($cat_name). '</td>';
		echo '</tr>';
	}
	echo '</table>';
}
else
	echo "No users registered in this color.";
?>
</div>
