<?php
/* @var $this MessageController */
/* @var $model BbiiMessage */
/* @var $count Array */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	Yii::t('bbii', 'Inbox'),
);

$item = array(
	array('label'=>Yii::t('bbii', 'Inbox') .' ('. $count['inbox'] .')', 'url'=>array('/forum/message/inbox')),
	array('label'=>Yii::t('bbii', 'Outbox') .' ('. $count['outbox'] .')', 'url'=>array('/forum/message/outbox')),
	array('label'=>Yii::t('bbii', 'New message'), 'url'=>array('/forum/message/create'))
);
?>
<div id="bbii-wrapper">
	<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>
	
	<div class="progress"><div class="progressbar" style="width:<?php echo (2*$count['outbox']); ?>%"> </div></div>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'inbox-grid',
		'dataProvider'=>$model->search(),
		'rowCssClassExpression'=>'($data->read_indicator)?"":"unread"',
		'columns'=>array(
			array(
				'name'=>'sendto',
				'value'=>'$data->receiver->member_name'
			),
			'subject',
			array(
				'name' => 'create_time',
				'value' => 'DateTimeCalculation::long($data->create_time)',
			),
			array(
				'name' => 'type',
				'value' => '($data->type)?Yii::t("bbii", "notification"):Yii::t("bbii", "message")',
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view}{delete}',
				'buttons' => array(
					'view' => array(
						'url'=>'$data->id',
						'imageUrl'=>$this->module->getRegisteredImage('view.png'),
						'click'=>'js:function() { viewMessage($(this).attr("href"), "' . $this->createAbsoluteUrl('message/view') .'");return false; }',
					),
					'delete' => array(
						'imageUrl'=>$this->module->getRegisteredImage('delete.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
				)
			),
		),
	)); ?>
	
	<div id="bbii-message"></div>

</div>