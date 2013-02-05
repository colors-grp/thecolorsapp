<?php
/* @var $this CategController */
/* @var $model Categ */

$this->breadcrumbs=array(
	'Categs'=>array('index'),
	$model->cat_name,
);

$this->menu=array(
	array('label'=>'List Categ', 'url'=>array('index')),
	array('label'=>'Create Categ', 'url'=>array('create')),
	array('label'=>'Update Categ', 'url'=>array('update', 'id'=>$model->cat_name)),
	array('label'=>'Delete Categ', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cat_name),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Categ', 'url'=>array('admin')),
);
?>

<h1>View Categ #<?php echo $model->cat_name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cat_name',
		'cat_user_num',
		'cat_points',
	),
)); ?>
