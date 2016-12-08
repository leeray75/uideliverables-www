<?php
/* @var $this SearchController */
/* @var $dataProvider CActiveDataProvider */
/* @var $search String */
/* @var $choice Integer */
/* @var $type Integer */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	Yii::t('bbii', 'Search'),
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
	
	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'bbii-search-form',
			'action'=>array('search/index'),
			'enableAjaxValidation'=>false,
	));
		echo CHtml::textField('search', $search, array('size'=>80,'maxlength'=>100));
		echo CHtml::submitButton(Yii::t('bbii','Search')) . '<br>';
		echo CHtml::radioButtonList('choice', $choice, array('1'=>Yii::t('bbii','Subject'), '2'=>Yii::t('bbii','Content'), '0'=>Yii::t('bbii','Both')), array('separator'=>'&nbsp;'));
		echo ' | ';
		echo CHtml::radioButtonList('type', $type, array('1'=>Yii::t('bbii','Any word'), '2'=>Yii::t('bbii','All words'), '0'=>Yii::t('bbii','Phrase')), array('separator'=>'&nbsp;'));
	$this->endWidget();
	?>

	<?php $this->widget('zii.widgets.CListView', array(
		'id'=>'bbii-search-result',
		'dataProvider'=>$dataProvider,
		'itemView'=>'_post',
	)); ?>
	
	<?php echo $this->renderPartial('_footer'); ?>
</div>