<?php
/* @var $this SiteController */

$this -> pageTitle = Yii::app() -> name;
foreach ($top_categories as $element) {
	echo '<a href="index.php?r=rankTable/index&cat=' . $element[1] . '">' .
	 		sprintf("%s (%d)", $element[1], $element[0]) .
	  	 '</a><br/>';
}

if($fb_id == 0)
	require_once 'login.php';
else
	require_once 'home.php';
?>
