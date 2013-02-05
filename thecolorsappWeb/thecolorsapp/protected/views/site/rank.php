<?php
	echo $cat_name . '</br><br/>';
	$i = 0;
	foreach ($top_rank_names as $record) {
		echo $record . ' => ' . $sorted_users[$i][1] . '<br/>';
		$i++;
	}
	echo '<br/><br/>Ranking Table <br/>';
	echo '<table border="1">';
	foreach ($sorted_users as $record) {
		echo '<tr>';
		echo '<td>'.$record[1].'</td>';
		echo '<td>'.$record[0].'</td>';
		echo '</tr>';
	}
	echo '</table>';
?>