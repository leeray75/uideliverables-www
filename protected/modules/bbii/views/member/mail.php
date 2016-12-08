<?php
/* @var $this MemberController */
/* @var $model MailForm */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	Yii::t('bbii', 'Members')=>array('/forum/member/index'),
	Yii::t('bbii', 'Send e-mail')
);

$item = array(
	array('label'=>Yii::t('bbii', 'Forum'), 'url'=>array('/forum/forum/index')),
	array('label'=>Yii::t('bbii', 'Members'), 'url'=>array('/forum/member/index')),
);
?>
<div id="bbii-wrapper">
	<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>
	
	<div class="bbii-box-top"><?php echo Yii::t('bbii', 'Send e-mail to') . ' ' . $model->member_name; ?></div>

	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'bbii-mail-form',
		'enableAjaxValidation'=>false,
	)); ?>

		<p class="note"><?php echo Yii::t('bbii', 'Fields with <span class="required">*</span> are required.'); ?></p>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'subject'); ?>
			<?php echo $form->textField($model,'subject',array('size'=>80,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'subject'); ?>
		</div>
		
		<div class="row">
			<?php $this->widget('forum.extensions.editMe.widgets.ExtEditMe', array(
				'model'=>$model,
				'attribute'=>'body',
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
			<?php echo $form->error($model,'body'); ?>
		</div>

		<div class="row buttons">
			<?php echo $form->hiddenField($model,'member_id'); ?>
			<?php echo $form->hiddenField($model,'member_name'); ?>
			<?php echo CHtml::submitButton(Yii::t('bbii', 'Send')); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
</div>