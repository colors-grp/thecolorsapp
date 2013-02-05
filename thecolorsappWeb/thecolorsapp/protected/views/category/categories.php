<script>
function categoryClick(name)
{
	window.location= "index.php?r=card/categoryCards&catg="+name;
}
</script>
<!-- <a href='index.php?r=login/afterLogin&user_id=<?php echo $_GET["user_id"]; ?>'> Home </a> -->
<div id="market" >
<?php
for($i=0;$i<count($userCategories);$i++)
{
   $cat_name=  $userCategories[$i]->cat_name;
   echo "<button type='button' id='category' onclick='categoryClick(". "\"$cat_name\"". ")'>";
   echo $cat_name;
   echo "</button>";
}
echo "<div id='pBox' >";
echo "Points u have: ". $userPoints;
echo ' <a href="'.CController::createUrl('purchase/buyPoints').'">Buy points</a>';
echo "</div> ";
?>
</div>
