<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $topic BbiiTopic */
/* @var $dataProvider CActiveDataProvider */
/* @var $postId integer */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	$forum->name => array('/forum/forum/forum', 'id'=>$forum->id),
	$topic->title,
);

$item = array(
	array('label'=>Yii::t('bbii', 'Forum'), 'url'=>array('/forum/forum/index')),
	array('label'=>Yii::t('bbii', 'Members'), 'url'=>array('/forum/member/index'))
);

Yii::app()->clientScript->registerScript('scrollToPost', "
	var aTag = $('a[name=\"" . $postId . "\"]');
	if(aTag.length > 0) {
		$('html,body').animate({scrollTop: aTag.offset().top},'fast');
	}
", CClientScript::POS_READY);

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
			<?php echo $topic->title; ?>
		</div>
	</div>
	
	<?php if(!(Yii::app()->user->isGuest || $topic->locked) || $this->isModerator()): ?>
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'create-post-form',
			'action'=>array('forum/reply', 'id'=>$topic->id),
			'enableAjaxValidation'=>false,
		)); ?>
			<?php echo CHtml::submitButton(Yii::t('bbii','Reply'), array('class'=>'bbii-topic-button')); ?>
		<?php $this->endWidget(); ?>
	</div><!-- form -->	
	<?php endif; ?>

	<?php $this->widget('zii.widgets.CListView', array(
		'id'=>'bbiiPost',
		'dataProvider'=>$dataProvider,
		'itemView'=>'_post',
	)); ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dlgReportForm',
    'options'=>array(
        'title'=>Yii::t('bbii', 'Report post'),
        'autoOpen'=>false,
		'modal'=>true,
		'width'=>800,
		'show'=>'fade',
		'buttons'=>array(
			Yii::t('bbii','Send')=>'js:function(){ sendReport(); }',
			Yii::t('bbii','Cancel')=>'js:function(){ $(this).dialog("close"); }',
		),
    ),
));

	echo $this->renderPartial('_reportForm', array('model'=>new BbiiMessage));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>