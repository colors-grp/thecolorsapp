<script>
$(document).ready(function(){
	$('#loading').hide();
	$("#ok").click(function(){
		$('#loading').show();
		var idx = $('#points:checked').val();
		$.ajax({
			url : "index.php?r=purchase/commit&points="+idx,
			success : function(result) {
				$('#loading').hide();
				alert(result);				
			}
		});
	});
});
</script>
<?php
echo "<form onsubmit='return false;'>";
for ($i=0;$i<count($packs) ;$i++) {
	$val = sprintf('%d points(%d$)', $packs[$i][0], $packs[$i][1]);
	echo '<input type="radio" id="points" name="points" value="'.$packs[$i][0].'" />'.$val.'<br/>';
}
echo '<input type="button" id="ok" value="OK"/>';
echo "</form>";
?>
<div id="loading" >
</div>