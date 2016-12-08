<?php
/* @var $this ForumController */
/* @var $item array */
?>
<div id="bbii-header">
	<?php if(!Yii::app()->user->isGuest): ?>
		<?php $messages = BbiiMessage::model()->inbox()->unread()->count('sendto = '.Yii::app()->user->id); ?>
		<div class="bbii-profile-box">
		<?php 
			echo CHtml::link($messages . ' ' . Yii::t('bbii', 'new messages'), array('message/inbox')); 
			echo ' | ' . CHtml::link(Yii::t('bbii', 'My settings'), array('member/view', 'id' =>Yii::app()->user->id)); 
			if($this->isAdmin()) echo ' | ' . CHtml::link(Yii::t('bbii', 'Forum settings'), array('setting/index'));
		?>
		</div>
	<?php endif; ?>
	<div class="bbii-title"><?php echo $this->module->forumTitle; ?></div>
	<table style="margin:0;"><tr><td style="padding:0;">
		<div id="bbii-menu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>$item
		)); ?>
		</div>
	</td><td style="padding:0;text-align:right;vertical-align:top;">
		<div class="search">
			<?php $this->widget('SimpleSearchForm'); ?>
		</div>
	</td></tr></table>
</div>
<?php if(isset($this->bbii_breadcrumbs)):?>
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>false,
		'links'=>$this->bbii_breadcrumbs,
	)); ?><!-- breadcrumbs -->
<?php endif?>