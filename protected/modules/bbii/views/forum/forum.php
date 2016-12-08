<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $dataProvider CArrayDataProvider */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	$forum->name,
);

$item = array(
	array('label'=>Yii::t('bbii', 'Forum'), 'url'=>array('/forum/forum/index')),
	array('label'=>Yii::t('bbii', 'Members'), 'url'=>array('/forum/member/index'))
);
?>

<?php if(Yii::app()->user->hasFlash('moderation')): ?>
<div class="flash-notice">
	<?php echo Yii::app()->user->getFlash('moderation'); ?>
</div>
<?php endif; ?>

<div id="bbii-wrapper">
	<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>
	
	<div class="forum-category center">
		<div class="header2">
			<?php echo $forum->name; ?>
		</div>
	</div>
	
	<?php if(!(Yii::app()->user->isGuest || $forum->locked) || $this->isModerator()): ?>
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'create-topic-form',
			'action'=>array('forum/createTopic'),
			'enableAjaxValidation'=>false,
		)); ?>
			<?php echo $form->hiddenField($forum, 'id'); ?>
			<?php echo CHtml::submitButton(Yii::t('bbii','Create new topic'), array('class'=>'bbii-topic-button')); ?>
		<?php $this->endWidget(); ?>
	</div><!-- form -->	
	<?php endif; ?>

	<?php $this->widget('zii.widgets.CListView', array(
		'id'=>'bbiiTopic',
		'dataProvider'=>$dataProvider,
		'itemView'=>'_topic',
	)); ?>
	
	<?php echo $this->renderPartial('_forumfooter'); ?>
</div>
<?php 
if($this->isModerator()) {
	$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
		'id'=>'dlgTopicForm',
		'options'=>array(
			'title'=>Yii::t('bbii', 'Update topic'),
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>800,
			'show'=>'fade',
			'buttons'=>array(
				Yii::t('bbii','Change')=>'js:function(){ changeTopic("' . $this->createAbsoluteUrl('moderator/changeTopic') . '"); }',
				Yii::t('bbii','Cancel')=>'js:function(){ $(this).dialog("close"); }',
			),
		),
	));

		echo $this->renderPartial('_topicForm', array('model'=>new BbiiTopic));

	$this->endWidget('zii.widgets.jui.CJuiDialog');
}
?>