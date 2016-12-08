<?php
/* @var $this ForumController */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	Yii::t('bbii', 'Members'),
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

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'member-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>'Avatar',
			'type'=>'image',
			'value'=>'(isset($data->avatar))?"'.Yii::app()->request->baseUrl . $this->module->avatarStorage . '/$data->avatar":"'.$this->module->getRegisteredImage('empty.jpeg').'"',
			'htmlOptions'=>array('class'=>'img30'),
		),
		array(
			'name' => 'member_name',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->member_name), array("/forum/member/view", "id"=>$data->id))',
		),
		array(
			'header' => Yii::t('bbii', 'Joined'),
			'value' => 'DateTimeCalculation::full($data->first_visit)',
		),
		array(
			'header' => Yii::t('bbii', 'Last visit'),
			'value' => 'DateTimeCalculation::full($data->last_visit)',
		),
		array(
			'name' => 'group_id',
			'filter' => CHtml::listData(BbiiMembergroup::model()->findAll(), 'id', 'name'),
			'value' => '(isset($data->group))?$data->group->name:""',
		),
	),
)); ?>

	
	<?php echo $this->renderPartial('_footer'); ?>
</div>