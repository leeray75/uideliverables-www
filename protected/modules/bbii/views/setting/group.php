<?php
/* @var $this SettingController */
/* @var $model BbiiMembergroup */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	Yii::t('bbii', 'Settings')=>array('/forum/setting/index'),
	Yii::t('bbii', 'Member groups')
);

$item = array(
	array('label'=>Yii::t('bbii', 'Settings'), 'url'=>array('/forum/setting/index')),
	array('label'=>Yii::t('bbii', 'Forum layout'), 'url'=>array('/forum/setting/layout')),
	array('label'=>Yii::t('bbii', 'Member groups'), 'url'=>array('/forum/setting/group')),
	array('label'=>Yii::t('bbii', 'Moderators'), 'url'=>array('/forum/setting/moderator'))
);

Yii::app()->clientScript->registerScript('confirmation', "
var confirmation = '" . Yii::t('bbii', 'Are you sure that you want to delete this member group?') . "'
", CClientScript::POS_BEGIN);
?>
<div id="bbii-wrapper">
	<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>
	
	<?php echo CHtml::button(Yii::t('bbii', 'New group'), array('onclick'=>'editMembergroup()', 'class'=>'down35')); ?>
	
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'membergroup-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			array(
				'name' => 'id',
	//			'visible'=>false,
			),
			'name',
			'description',
			'min_posts',
			array(
				'name' => 'color',
				'type' => 'raw',
				'value' => '"<span style=\"font-weight:bold;color:#$data->color\">$data->color</span>"',
			),
			'image',
			array(
				'class'=>'CButtonColumn',
				'template'=>'{update}',
				'buttons' => array(
					'update' => array(
						'click'=>'js:function($data) { editMembergroup($(this).closest("tr").children("td:first").text(), "' . $this->createAbsoluteUrl('setting/getMembergroup') .'");return false; }',
					),
				)
			),
		),
	)); ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dlgEditMembergroup',
    'options'=>array(
        'title'=>'Edit',
        'autoOpen'=>false,
		'modal'=>true,
		'width'=>450,
		'show'=>'fade',
		'buttons'=>array(
			'Delete'=>'js:function(){ deleteMembergroup("' . $this->createAbsoluteUrl('setting/deleteMembergroup') .'"); }',
			'Save'=>'js:function(){ saveMembergroup("' . $this->createAbsoluteUrl('setting/saveMembergroup') .'"); }',
			'Cancel'=>'js:function(){ $(this).dialog("close"); }',
		),
    ),
));

    echo $this->renderPartial('_editMembergroup', array('model'=>$model));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>