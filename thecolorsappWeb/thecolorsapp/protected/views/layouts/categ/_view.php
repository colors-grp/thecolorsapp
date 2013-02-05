<?php
/* @var $this CategController */
/* @var $data Categ */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cat_name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cat_name), array('view', 'id'=>$data->cat_name)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cat_user_num')); ?>:</b>
	<?php echo CHtml::encode($data->cat_user_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cat_points')); ?>:</b>
	<?php echo CHtml::encode($data->cat_points); ?>
	<br />


</div>