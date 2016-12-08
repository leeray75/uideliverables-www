<?php
/* @var $this MessageController */
/* @var $model BbiiMessage */
/* @var $count Array */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	Yii::t('bbii', 'New message'),
);

$item = array(
	array('label'=>Yii::t('bbii', 'Inbox') .' ('. $count['inbox'] .')', 'url'=>array('/forum/message/inbox')),
	array('label'=>Yii::t('bbii', 'Outbox') .' ('. $count['outbox'] .')', 'url'=>array('/forum/message/outbox')),
	array('label'=>Yii::t('bbii', 'New message'), 'url'=>array('/forum/message/create'))
);
?>
<div id="bbii-wrapper">
	<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>

	<h1><?php echo Yii::t('bbii', 'New message'); ?></h1>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>