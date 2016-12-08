<?php
/* @var $this ForumController */
/* @var $dataProvider CArrayDataProvider */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum'),
);

$approvals = BbiiPost::model()->unapproved()->count();
$reports = BbiiMessage::model()->report()->count();

$item = array(
	array('label'=>Yii::t('bbii', 'Forum'), 'url'=>array('/forum/forum/index')),
	array('label'=>Yii::t('bbii', 'Members'), 'url'=>array('/forum/member/index')),
	array('label'=>Yii::t('bbii', 'Approval'). ' (' . $approvals . ')', 'url'=>array('/forum/moderator/approval'), 'visible'=>$this->isModerator()),
	array('label'=>Yii::t('bbii', 'Reports'). ' (' . $reports . ')', 'url'=>array('/forum/moderator/report'), 'visible'=>$this->isModerator()),
	array('label'=>Yii::t('bbii', 'Posts'), 'url'=>array('/forum/moderator/admin'), 'visible'=>$this->isModerator()),
	array('label'=>Yii::t('bbii', 'Blocked IP'), 'url'=>array('/forum/moderator/ipadmin'), 'visible'=>$this->isModerator()),
);
?>
<div id="bbii-wrapper">
	<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>

	<?php $this->widget('zii.widgets.CListView', array(
		'id'=>'bbiiForum',
		'dataProvider'=>$dataProvider,
		'itemView'=>'_forum',
		'summaryText'=>false,
	)); ?>
	
	<?php echo $this->renderPartial('_footer'); ?>
	<?php if(!Yii::app()->user->isGuest) echo CHtml::link(Yii::t('bbii','Mark all read'), array('forum/markAllRead')); ?>
</div>