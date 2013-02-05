<script>
	function loginFacebook(){
		top.location.href = '<?php echo Yii::app()->facebook->getLoginUrl();?>';
	}
</script>

<button onclick="loginFacebook();"> Login </button>