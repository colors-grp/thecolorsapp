<script>
$(document).ready(function(){
	$('#login').click(function(){
		top.location.href = '<?php echo Yii::app()->facebook->getLoginUrl();?>';
	});
});
</script>
<?php
echo "Please login to access this page";
?>
<button id='login' > Login </button>