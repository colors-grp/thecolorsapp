<script>
$(document).ready(function(){
	$('#loading').hide();
	$('#purch').click(function(){
		var user_id = "<?php echo $user_id; ?>";
		var card_id = <?php echo $card_id; ?>;
		var cat_name = "<?php echo $cat_name; ?>";		
		$.ajax({
			type: "GET",
			url: "index.php?r=purchase/purchase",
			data: {user_id: user_id , card_id: card_id, cat_name: cat_name},
			beforeSend: function(){ $('#loading').show();}
		}).done(function(msg){
			$('#loading').hide();
			alert(msg);
		});
	});
	$('#home').click(function(){
		var ID = "<?php echo $user_id ?>";
		var name = "<?php echo $cat_name; ?>";
		window.location = "index.php?r=marektPlace/generateCards&catg="+name+"&id="+ID;
	});
});
</script>
<?php
for ($i=0 ; $i <count($picURL) ; $i++)
{
	echo "<div id=\"". $cssName[$i]. "\" style=\"". "background-image:url('$picURL[$i]')". "\">";
	echo "</div>";
}
?>
<div id="loading">
</div>
<button type="button" id="purch"> Purchase </button>

<!--<button  type="button" id="home"> Back to cards </button> -->
