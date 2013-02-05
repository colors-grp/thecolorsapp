<script type="text/javascript">
$(document).ready(function(){
	$('#loading').hide();
	$('#sel').change(function(){
		$.ajax({
			type: "GET",
			url: "index.php?r=rank/CategoryRanksNames",
			data: {catg_name: $('#sel').val()},
			beforeSend: function(){ $('#loading').show();}
		}).done(function(ht){
			$('#loading').hide();
			$('#currentRanks').html(ht);
		});
	});
	$('#addR').click(function(){
		$.ajax({
			type: "GET",
			url: "index.php?r=rank/addRank",
			data: {catg_name: $('#sel').val(), rank_name: $('#rankName').val(), rank_pr: $('#rankPr').val()},
			beforeSend: function(){ $('#loading').show();}
		}).done(function(){
			$('#loading').hide();
			window.location.reload();
		});
	});
	$('#addC').click(function(){
		$.ajax({
			type: "GET",
			url: "index.php?r=category/addCategory",
			data: {catg_name: $('#catName').val(), rank_eq: "eee"},
			beforeSend: function(){ $('#loading').show();}
		}).done(function(){
			$('#loading').hide();
			window.location.reload();
		});
	});
	$('#addB').click(function(){
		$.ajax({
			type: "GET",
			url: "index.php?r=purchase/addBuy",
			data: {buy_points: $('#points').val(), buy_price: $('#price').val()},
			beforeSend: function(){ $('#loading').show();}
		}).done(function(){
			$('#loading').hide();
			window.location.reload();
		});
	});
});
</script>

<div id="categ">
	<div id="addRank">
		Select Category to add new rank
		<select id ="sel">
			<option value="none"> Select </option>
			<?php
				for($i=0;$i<count($allCat);$i++)
				{
					$catName = &$allCat[$i]->cat_name;
					echo  "<option value='". $catName. "'>". $catName. "</option>";
				}	
			?>
		</select> <br>
		<div id="currentRanks">
		</div>
		Rank Name: <input type="text" id="rankName"> <br>
		Rank priority: <input type="text" id="rankPr"> <br>
		<button id="addR" > Add Rank </button>
	</div>
	<div id="newCat">
		Catgeory Name: <input type="text" id="catName"> <br>
		Rank Equation: <input type="text" id="rankEq" disabled> <br>
		<button id="addC" > Add Category </button>
	</div>
</div>
<div id="addBuyPts">
	<table border="3px">
		<tr>
			<th id="transHeader"> Points </th>
			<th id="transHeader"> Price </th>
		</tr>
	<?php
	for($i=0;$i<count($allBuy);$i++)
	{
		$singleBuy = &$allBuy[$i];
		echo "<tr>";
			echo "<td>". $singleBuy->buy_points. "</td>";
			echo "<td>". $singleBuy->buy_price. "$</td>";
		echo "</tr>";
	}
	?>
	</table>
	Points: <input type="text" id="points"> <br>
	Price: <input type="text" id="price" > <br>
	<button id="addB" > Add Points </button>
</div>
<div id="loading">
</div>