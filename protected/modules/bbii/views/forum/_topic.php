<?php
/* @var $this ForumController */
/* @var $data BbiiTopic */
?>

<div class="topic">
	<div class="forum-cell">
		<?php 
		if($this->topicIsRead($data->id)) {
			if($data->locked) {
				if($data->global) {
					echo CHtml::image($this->module->getRegisteredImage('forum2_gl.png'), 'locked topic', array('style'=>'width:33px;height:34px;'));
				} elseif($data->sticky) {
					echo CHtml::image($this->module->getRegisteredImage('forum2_sl.png'), 'locked topic', array('style'=>'width:33px;height:34px;'));
				} else {
					echo CHtml::image($this->module->getRegisteredImage('forum2_l.png'), 'locked topic', array('style'=>'width:33px;height:34px;'));
				}
			} elseif($data->global) {
				echo CHtml::image($this->module->getRegisteredImage('forum2_g.png'), 'global topic', array('style'=>'width:33px;height:34px;'));
			} elseif($data->sticky) {
				echo CHtml::image($this->module->getRegisteredImage('forum2_s.png'), 'global topic', array('style'=>'width:33px;height:34px;'));
			} else {
				echo CHtml::image($this->module->getRegisteredImage('forum2.png'), 'unread topic', array('style'=>'width:33px;height:34px;'));
			}
		} else {
			if($data->locked) {
				if($data->global) {
					echo CHtml::image($this->module->getRegisteredImage('forum1_gl.png'), 'locked topic', array('style'=>'width:33px;height:34px;'));
				} elseif($data->sticky) {
					echo CHtml::image($this->module->getRegisteredImage('forum1_sl.png'), 'locked topic', array('style'=>'width:33px;height:34px;'));
				} else {
					echo CHtml::image($this->module->getRegisteredImage('forum1_l.png'), 'locked topic', array('style'=>'width:33px;height:34px;'));
				}
			} elseif($data->global) {
				echo CHtml::image($this->module->getRegisteredImage('forum1_g.png'), 'global topic', array('style'=>'width:33px;height:34px;'));
			} elseif($data->sticky) {
				echo CHtml::image($this->module->getRegisteredImage('forum1_s.png'), 'global topic', array('style'=>'width:33px;height:34px;'));
			} else {
				echo CHtml::image($this->module->getRegisteredImage('forum1.png'), 'unread topic', array('style'=>'width:33px;height:34px;'));
			}
		}
		?>
	</div>
	<div class="forum-cell main">
		<div class="header2">
			<?php echo CHtml::link(CHtml::encode($data->title), array('topic', 'id'=>$data->id)); ?>
		</div>
		<div class="header4">
			<?php echo Yii::t('bbii', 'Started by') . ': ' . CHtml::encode($data->starter->member_name);?>
			<?php echo ' ' . Yii::t('bbii', 'on') . ' ' . DateTimeCalculation::medium($data->firstPost->create_time); ?>
		<?php if($this->isModerator()): ?>
			<?php echo CHtml::image($this->module->getRegisteredImage('empty.png'), 'empty'); ?>
			<?php echo CHtml::image($this->module->getRegisteredImage('update.png'), 'update', array('title'=>Yii::t('bbii', 'Update topic'), 'style'=>'cursor:pointer', 'onclick'=>'updateTopic(' . $data->id . ', "' . $this->createAbsoluteUrl('moderator/topic') . '")')); ?>
		<?php endif; ?>
		</div>
	</div>
	<div class="forum-cell center">
		<?php echo CHtml::encode($data->num_replies); ?><br>
		<?php echo CHtml::encode($data->getAttributeLabel('num_replies')); ?>
	</div>
	<div class="forum-cell center">
		<?php echo CHtml::encode($data->num_views); ?><br>
		<?php echo CHtml::encode($data->getAttributeLabel('num_views')); ?>
	</div>
	<div class="forum-cell last-cell">
		<?php 
			echo CHtml::encode($data->lastPost->poster->member_name);
			echo CHtml::link(CHtml::image($this->module->getRegisteredImage('next.png'), 'next', array('style'=>'margin-left:5px;')), array('topic', 'id'=>$data->id, 'nav'=>'last'));
			echo '<br>';
			echo DateTimeCalculation::long($data->lastPost->create_time);
		?>
	</div>
</div>