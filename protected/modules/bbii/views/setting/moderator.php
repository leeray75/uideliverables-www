<?php
/* @var $this ForumController */
/* @var $model BbiiSetting */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	Yii::t('bbii', 'Settings')=>array('/forum/setting/index'),
	Yii::t('bbii', 'Moderators')
);

$item = array(
	array('label'=>Yii::t('bbii', 'Settings'), 'url'=>array('/forum/setting/index')),
	array('label'=>Yii::t('bbii', 'Forum layout'), 'url'=>array('/forum/setting/layout')),
	array('label'=>Yii::t('bbii', 'Member groups'), 'url'=>array('/forum/setting/group')),
	array('label'=>Yii::t('bbii', 'Moderators'), 'url'=>array('/forum/setting/moderator'))
);
?>
<div id="bbii-wrapper">
	<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>
	
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'bbii-member-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'rowCssClassExpression'=>'(Yii::app()->authManager && Yii::app()->authManager->checkAccess("moderator", $data->id))?"moderator":(($row % 2)?"even":"odd")',
		'columns'=>array(
			'member_name',
			array(
				'name'=>'group_id',
				'value'=>'$data->group->name',
				'filter'=>CHtml::listData(BbiiMembergroup::model()->findAll(), 'id', 'name'),
			),
			array(
				'name'=>'moderator',
				'value'=>'CHtml::checkBox("moderator", $data->moderator, array("onclick"=>"changeModeration(this,$data->id,\'' . $this->createAbsoluteUrl('setting/changeModerator') . '\')"))',
				'type'=>'raw',
				'filter'=>array('0'=>Yii::t('bbii', 'No'), '1'=>Yii::t('bbii', 'Yes')),
				'htmlOptions'=>array("style"=>"text-align:center"),
			),
			
		),
	)); ?>
</div>