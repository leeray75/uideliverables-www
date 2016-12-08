<?php
/* @var $this ModeratorController */
/* @var $model BbiiMessage */

$this->bbii_breadcrumbs=array(
	Yii::t('bbii', 'Forum')=>array('/forum/forum/index'),
	Yii::t('bbii', 'Reports'),
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

	<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'message-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			array(
				'name' => 'sendfrom',
				'value' => '$data->sender->member_name',
				'filter' => false,
			),
			'subject',
			array(
				'name'=>'content',
				'type'=>'html',
			),
			'create_time',
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view}{reply}{delete}',
				'buttons' => array(
					'view' => array(
						'url'=>'array("forum/topic", "id"=>$data->forumPost->topic_id, "nav"=>$data->post_id)',
						'label'=>Yii::t('bbii','Go to post'),
						'imageUrl'=>$this->module->getRegisteredImage('goto.png'),
					),
					'reply' => array(
						'url'=>'array("message/reply", "id"=>$data->id)',
						'label'=>Yii::t('bbii','Reply'),
						'imageUrl'=>$this->module->getRegisteredImage('reply.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
					'delete' => array(
						'url'=>'array("message/delete", "id"=>$data->id)',
						'imageUrl'=>$this->module->getRegisteredImage('delete.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
				)
			),
		),
	)); ?>
</div>