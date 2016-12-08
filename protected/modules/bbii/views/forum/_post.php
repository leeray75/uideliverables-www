<?php
/* @var $this ForumController */
/* @var $data BbiiPost */
?>

<div class="post">
	<?php echo CHtml::tag('a', array('name'=>$data->id)); ?>
	<div class="member-cell">
		<div class="membername">
			<?php echo CHtml::link(CHtml::encode($data->poster->member_name), array('/forum/member/view', 'id'=>$data->poster->id)); ?>
		</div>
		<div class="avatar">
			<?php echo CHtml::image((isset($data->poster->avatar))?(Yii::app()->request->baseUrl . $this->module->avatarStorage . '/'. $data->poster->avatar):$this->module->getRegisteredImage('empty.jpeg'), 'avatar'); ?>
		</div>
		<div class="group">
			<?php if(isset($data->poster->group)) {
				if(isset($data->poster->group->image)) {
					echo CHtml::image($this->module->getRegisteredImage($data->poster->group->image), 'group') . '<br>';
				}
				echo CHtml::encode($data->poster->group->name);
			} ?>
		</div>
		<div class="memberinfo">
			<?php echo Yii::t('bbii', 'Posts') . ': ' . CHtml::encode($data->poster->posts); ?><br>
			<?php echo Yii::t('bbii', 'Joined') . ': ' . DateTimeCalculation::shortDate($data->poster->first_visit); ?>
		</div>
		<div style="text-align:center;margin-top:10px;">
		<?php if(!Yii::app()->user->isGuest): ?>
			<?php echo CHtml::image($this->module->getRegisteredImage('warn.png'), 'warn', array('title'=>Yii::t('bbii', 'Report post'), 'style'=>'cursor:pointer;', 'onclick'=>'reportPost(' . $data->id . ')')); ?>
			<?php echo CHtml::link( CHtml::image($this->module->getRegisteredImage('pm.png'), 'pm', array('title'=>Yii::t('bbii', 'Send private message'))), array('message/create', 'id'=>$data->user_id) ); ?>
		<?php endif; ?>
		</div>
	</div>
	<div class="post-cell">
		<div class="post-header">
			<?php if(!(Yii::app()->user->isGuest || $data->topic->locked) || $this->isModerator()): ?>
				<div class="form">
					<?php $form=$this->beginWidget('CActiveForm', array(
						'action'=>array('forum/quote', 'id'=>$data->id),
						'enableAjaxValidation'=>false,
					)); ?>
						<?php echo CHtml::submitButton(Yii::t('bbii','Quote'), array('class'=>'bbii-quote-button')); ?>
					<?php $this->endWidget(); ?>
				</div><!-- form -->	
			<?php endif; ?>
			<?php if(!($data->user_id != Yii::app()->user->id || $data->topic->locked) || $this->isModerator()): ?>
				<div class="form">
					<?php $form=$this->beginWidget('CActiveForm', array(
						'action'=>array('forum/update', 'id'=>$data->id),
						'enableAjaxValidation'=>false,
					)); ?>
						<?php echo CHtml::submitButton(Yii::t('bbii','Edit'), array('class'=>'bbii-edit-button')); ?>
					<?php $this->endWidget(); ?>
				</div><!-- form -->	
			<?php endif; ?>
			<div class="header2"><?php echo CHtml::encode($data->subject); ?></div>
			<?php echo '&raquo; ' . CHtml::encode($data->poster->member_name); ?>
			<?php echo ' &raquo; ' . DateTimeCalculation::full($data->create_time); ?>
		</div>
		<div class="post-content">
			<?php echo $data->content; ?>
		</div>
		<div class="signature">
			<?php echo $data->poster->signature; ?>
		</div>
		<div class="post-footer">
			<?php if($data->change_reason): ?>
				<?php echo Yii::t('bbii','Changed'). ': ' . DateTimeCalculation::long($data->change_time) . ' ' . Yii::t('bbii','Reason') . ': ' . CHtml::encode($data->change_reason); ?>
			<?php endif; ?>
		</div>
		<div class="toolbar">
		<?php if($this->isModerator()): ?>
			<?php echo CHtml::link( CHtml::image($this->module->getRegisteredImage('warn.png'), 'warn', array('title'=>Yii::t('bbii', 'Warn user'))), array('message/create', 'id'=>$data->user_id, 'type'=>1) ); ?>
			<?php echo CHtml::image($this->module->getRegisteredImage('delete.png'), 'delete', array('title'=>Yii::t('bbii', 'Delete post'), 'style'=>'cursor:pointer;', 'onclick'=>'if(confirm("' . Yii::t('bbii','Do you really want to delete this post?') . '")) { deletePost("' . $this->createAbsoluteUrl('moderator/delete', array('id'=>$data->id)) . '") }')); ?>
			<?php echo CHtml::image($this->module->getRegisteredImage('ban.png'), 'ban', array('title'=>Yii::t('bbii', 'Ban IP address'), 'style'=>'cursor:pointer;', 'onclick'=>'if(confirm("' . Yii::t('bbii','Do you really want to ban this IP address?') . '")) { banIp(' . $data->id . ', "' . $this->createAbsoluteUrl('moderator/banIp') . '") }')); ?>
		<?php endif; ?>
		</div>
	</div>
</div>