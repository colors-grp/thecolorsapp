<?php
/* @var $this CategController */
/* @var $model Categ */

$this->breadcrumbs=array(
	'Categs'=>array('index'),
	$model->cat_name=>array('view','id'=>$model->cat_name),
	'Update',
);

$this->menu=array(
	array('label'=>'List Categ', 'url'=>array('index')),
	array('label'=>'Create Categ', 'url'=>array('create')),
	array('label'=>'View Categ', 'url'=>array('view', 'id'=>$model->cat_name)),
	array('label'=>'Manage Categ', 'url'=>array('admin')),
);
?>

<h1>Update Categ <?php echo $model->cat_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>