<?php
/* @var $this SettingController */
/* @var $model BbiiMembergroup */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCssFile($this->module->getAssetsUrl() . '/css/colorpicker.css');
Yii::app()->clientScript->registerScriptFile($this->module->getAssetsUrl() . '/js/colorpicker.js');
Yii::app()->clientScript->registerScriptFile($this->module->getAssetsUrl() . '/js/bbiiColorPicker.js', CClientScript::POS_END);

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'edit-membergroup-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note"><?php echo Yii::t('bbii', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>40)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>40)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'min_posts'); ?>
		<?php echo $form->textField($model,'min_posts',array('size'=>10)); ?>
		<?php echo $form->error($model,'min_posts'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'color'); ?>
		<?php echo $form->textField($model, 'color', array('id'=>'colorpickerField', 'style'=>'width:70px;')); ?>
		<?php echo CHtml::textField('colorpickerColor', '', array('style'=>'width:40px;', 'readonly'=>true)); ?>
		<?php echo $form->error($model,'color'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->textField($model,'image',array('size'=>40)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'id'); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->