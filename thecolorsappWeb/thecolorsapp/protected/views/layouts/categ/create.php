<?php
/* @var $this CategController */
/* @var $model Categ */

$this->breadcrumbs=array(
	'Categs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Categ', 'url'=>array('index')),
	array('label'=>'Manage Categ', 'url'=>array('admin')),
);
?>

<h1>Create Categ</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>