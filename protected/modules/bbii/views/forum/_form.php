<?php
/* @var $this ForumController */
/* @var $post BbiiPost */
/* @var $form CActiveForm */
?>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'create-topic-form',
		'enableAjaxValidation'=>false,
	)); ?>
		<?php echo $form->errorSummary($post); ?>
		
		<div class="row">
			<?php echo $form->labelEx($post,'subject'); ?>
			<?php echo $form->textField($post,'subject',array('size'=>100,'maxlength'=>255,'style'=>'width:99%;')); ?>
			<?php echo $form->error($post,'subject'); ?>
		</div>
		
		<div class="row">
		<?php $this->widget('forum.extensions.editMe.widgets.ExtEditMe', array(
			'model'=>$post,
			'attribute'=>'content',
			'height'=>400,
			'toolbar'=>array(
				array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'),
				array('Find','Replace','-','SelectAll'),
				array('Bold', 'Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'),
				'-',
				array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
					'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
				array('Link', 'Unlink','Image','Iframe','Preview'),
				array('/'),
				array('Styles','Format','Font','FontSize'),
				array('TextColor','BGColor'),
				array('HorizontalRule','Smiley','SpecialChar','-','ShowBlocks')
			)
		)); ?>
		<?php echo $form->error($post,'content'); ?>
	</div>
	
	<?php if(!$post->isNewRecord): ?>
		<div class="row">
			<?php echo $form->labelEx($post,'change_reason'); ?>
			<?php echo $form->textField($post,'change_reason',array('size'=>100,'maxlength'=>255,'style'=>'width:99%;')); ?>
			<?php echo $form->error($post,'change_reason'); ?>
		</div>
	<?php endif; ?>
		
	<div class="row button">
		<?php echo $form->hiddenField($post, 'forum_id'); ?>
		<?php echo $form->hiddenField($post, 'topic_id'); ?>
		<?php echo CHtml::submitButton(($post->isNewRecord)?Yii::t('bbii','Create'):Yii::t('bbii','Save'), array('class'=>'bbii-topic-button')); ?>
	</div>
	
	<?php $this->endWidget(); ?>
</div><!-- form -->	
