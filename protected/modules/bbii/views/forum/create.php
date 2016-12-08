<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $post BbiiPost */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	$forum->name => array('/forum/forum/forum', 'id'=>$forum->id),
	Yii::t('bbii', 'New topic'),
);

$item = array(
	array('label'=>Yii::t('bbii', 'Forum'), 'url'=>array('/forum/forum/index')),
	array('label'=>Yii::t('bbii', 'Members'), 'url'=>array('/forum/member/index'))
);
?>
<div id="bbii-wrapper">
	<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>
	
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'create-topic-form',
			'enableAjaxValidation'=>false,
		)); ?>
		<div class="row">
			<?php echo $form->labelEx($post,'subject'); ?>
			<?php echo $form->textField($post,'subject',array('size'=>100,'maxlength'=>255,'style'=>'width:99%;')); ?>
			<?php echo $form->error($post,'subject'); ?>
		</div>
		
		<?php echo $form->errorSummary($post); ?>

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
		
		<?php if($this->isModerator()): ?>
		
			<div class="row">
				<strong><?php echo Yii::t('bbii','Sticky'); ?>:</strong>
				<?php echo CHtml::checkbox('sticky'); ?> &nbsp; 
				<strong><?php echo Yii::t('bbii','Global'); ?>:</strong>
				<?php echo CHtml::checkbox('global'); ?> &nbsp; 
				<strong><?php echo Yii::t('bbii','Locked'); ?>:</strong>
				<?php echo CHtml::checkbox('locked'); ?> &nbsp; 
			</div>
		
		<?php endif; ?>
		
		<div class="row button">
			<?php echo $form->hiddenField($post, 'forum_id'); ?>
			<?php echo CHtml::submitButton(Yii::t('bbii','Save'), array('class'=>'bbii-topic-button')); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div><!-- form -->	

</div>