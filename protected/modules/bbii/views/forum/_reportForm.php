<?php
/* @var $this ForumController */
/* @var $model BbiiMessage */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'report-form',
	'enableAjaxValidation'=>true,
)); ?>

	<div class="row">
		<?php echo CHtml::label(Yii::t('bbii','Short explanation'), 'Bbii_content'); ?>
		<?php $this->widget('forum.extensions.editMe.widgets.ExtEditMe', array(
			'model'=>$model,
			'attribute'=>'content',
			'height'=>'200px',
			'toolbar'=>array(
				array(
					'Bold', 'Italic', 'Underline', 'RemoveFormat'
				),
			),
		)); ?>
		<?php echo $form->error($model,'content'); ?>
		<?php echo $form->hiddenField($model, 'post_id'); ?>
		<?php echo CHtml::hiddenField('url', $this->createAbsoluteUrl('message/sendReport')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->