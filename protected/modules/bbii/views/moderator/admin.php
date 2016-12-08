<?php
/* @var $this ModeratorController */
/* @var $model BbiiPost */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	Yii::t('bbii', 'Posts'),
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

Yii::app()->clientScript->registerScript('setAutocomplete', "
function setAutocomplete(id, data) {
    $('#BbiiPost_search').autocomplete({
		source: '" . $this->createUrl('member/members') . "',
		select: function(event,ui) {
			$('#BbiiPost_search').val(ui.item.label);
			$('#bbii-post-grid').yiiGridView('update', { data: $(this).serialize() });
			return false;
		},
		'minLength': 2,
		'delay': 200
	});
}
");

?>

<div id="bbii-wrapper">
	<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>

	<?php 
	$dataProvider = $model->search();
	$dataProvider->setPagination(array('pageSize'=>20));
	$dataProvider->setSort(array('defaultOrder'=>'create_time DESC'));
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'bbii-post-grid',
		'dataProvider'=>$dataProvider,
		'filter'=>$model,
		'afterAjaxUpdate'=>'setAutocomplete',
		'columns'=>array(
			array(
				'name' => 'forum_id',
				'value' => '$data->forum->name',
				'filter' => CHtml::listData(BbiiForum::model()->forum()->sorted()->findAll(), 'id', 'name'),
			),
			'subject',
			array(
				'name' => 'search',
				'filter' =>$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
					'attribute'=>'search',
					'model'=>$model,
					'sourceUrl'=>array('member/members'),
					'options'=>array(
						'minLength'=>2,
						'delay'=>200,
						'select'=>'js:function(event, ui) { 
							$("#BbiiPost_search").val(ui.item.label);
							$("#bbii-post-grid").yiiGridView("update", { data: $(this).serialize() });
							return false;
						}',
					),
					'htmlOptions'=>array(
						'style'=>'height:20px;',
					),
				), true),
				'value' => '$data->poster->member_name',
			),
			'ip',
			'create_time',
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view}{update}{delete}',
				'buttons' => array(
					'view' => array(
						'url'=>'array("forum/topic", "id"=>$data->topic_id, "nav"=>$data->id)',
						'imageUrl'=>$this->module->getRegisteredImage('view.png'),
					),
					'update' => array(
						'url'=>'array("forum/update", "id"=>$data->id)',
						'label'=>Yii::t('bbii','Update'),
						'imageUrl'=>$this->module->getRegisteredImage('update.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
					'delete' => array(
						'imageUrl'=>$this->module->getRegisteredImage('delete.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
				)
			),
		),
	)); ?>
</div>