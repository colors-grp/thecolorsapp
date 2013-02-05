<script>
$(document).ready(function(){
	$('#loading').hide();
	$('#save').click(function(){
		$('[id="check"]').each(function(index){
			var name=  $(this).val();
			var ID = "<?php echo $user_id; ?>";
			var check = $(this).is(':checked') ? 1 : 0 ;
			var len = $('[id="check"]').length;
			$.ajax({
				type: "GET",
				url: "index.php?r=user/save",
				data: { cat_name: name, state: check, user_id: ID},
				beforeSend: function(){ $('#loading').show();}
			}).done(function(){
				//alert("done");
				if(index == (len-1))
				{
					$('#loading').hide();
					var ID = "<?php echo $user_id ?>";
					window.location.reload();
				}
			});
		});
		//var ID = "<?php echo $user_id ?>";
		//window.location.reload();
		
	});
	$('#home').click(function(){
	
		var ID = "<?php echo $user_id ?>";
		window.location = "index.php?r=site/index&user_id="+ID;
	});
});
</script>
<?php

echo "<div>";
foreach($allCateg as $catg)
{
	$name = $catg->getAttribute('cat_name');
	if(!isset($followedCategory[$catg->getAttribute('cat_name')]))
	{
		echo "<input type='checkbox' id='check' value='$name'/>". $name. "<br>";
	}
	else
	{
		echo "<input type='checkbox' id='check' value='$name' checked disabled/>". $name. "<br>";
	}
}
?>
<button type="button" id="save"> Save </button>
<!--<button  type="button" id="home"> Home </button> -->
</div>
<div id="res">
</div>
<div id="loading">
</div>