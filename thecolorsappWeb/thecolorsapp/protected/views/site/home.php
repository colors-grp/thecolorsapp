<script>
	function logoutFacebook() {
		$.ajax({
			url : "index.php?r=site/logout",
			success : function(result) {
				top.location.href = '<?php echo CController::createUrl("site/index")?>';		
			}
		});
		
	}
</script>
<br/><br/>
<a style="float:right;" href="javascript:logoutFacebook();" > Log Out </a>
<ul>
<li> <a href="index.php?r=settings/settings&user_id=<?php echo $fb_id;?>">My Colors</a><br/> </li>
<li> <a href="index.php?r=marektPlace/showMarket&user_id=<?php echo $fb_id?>" > My Market </a> </li>
<li> <a href="index.php?r=settings/settings&user_id=<?php echo $fb_id?>" > My Settings </a> </li>
<li> <a href="index.php?r=transactions/transactions&user_id=<?php echo $fb_id?>" > My Transactions </a> </li>
</ul>

