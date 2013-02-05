<?php
/* @var $this UserController */

foreach ($topCategories as $element) {
	echo '<a href="index.php?r=rank/CategoryRanks&cat_name=' . $element[1] . '">' .
	 		sprintf("%s (%d)", $element[1], $element[0]) .
	  	 '</a><br/>';
}

?>
<script>
	function loginFacebook(){
		top.location.href = '<?php echo Yii::app()->facebook->getLoginUrl();?>';
	}
</script>

<button onclick="loginFacebook();"> Login </button>