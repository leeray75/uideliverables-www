<?php
/* @var $this MessageController */
/* @var $model BbiiMessage */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sendto'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
				'attribute'=>'search',
				'model'=>$model,
				'sourceUrl'=>array('member/members'),
				'options'=>array(
					'minLength'=>2,
					'delay'=>200,
					'select'=>'js:function(event, ui) { 
						$("#BbiiMessage_search").val(ui.item.label);
						$("#BbiiMessage_sendto").val(ui.item.value);
						return false;
					}',
				),
				'htmlOptions'=>array(
					'style'=>'height:20px;',
				),
			)); 
		?>
		<?php echo $form->hiddenField($model,'sendto'); ?>
		<?php echo $form->error($model,'sendto'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>100,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>
	
	<div class="row">
		<?php $this->widget('forum.extensions.editMe.widgets.ExtEditMe', array(
			'model'=>$model,
			'attribute'=>'content',
			'height'=>'300px',
			'toolbar'=>array(
				array(
					'Bold', 'Italic', 'Underline', 'RemoveFormat'
				),
				array(
						'TextColor', 'BGColor',
				),
				'-',
					array('Link', 'Unlink', 'Image'),
			),
		)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo $form->hiddenField($model,'type'); ?>
		<?php echo CHtml::submitButton(Yii::t('bbii', 'Send')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->