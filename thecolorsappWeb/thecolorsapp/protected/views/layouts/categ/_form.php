<?php
/* @var $this CategController */
/* @var $model Categ */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categ-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cat_name'); ?>
		<?php echo $form->textField($model,'cat_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'cat_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cat_user_num'); ?>
		<?php echo $form->textField($model,'cat_user_num'); ?>
		<?php echo $form->error($model,'cat_user_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cat_points'); ?>
		<?php echo $form->textField($model,'cat_points',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'cat_points'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->