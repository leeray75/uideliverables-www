<?php
/* @var $this ForumController */
?>
<div id="bbii-footer">
	<table><tr>
		<td class="legend">
			<table>
				<caption>
					<?php echo Yii::t('bbii','Forum legend'); ?>
				</caption>
				<tr>
					<td>
						<?php echo CHtml::image($this->module->getRegisteredImage('forum1.png'), 'unread topic', array('style'=>'width:33px;height:34px;vertical-align:middle;')); ?>
					</td>
					<td>
						<?php echo Yii::t('bbii','Normal topic'); ?>
					</td>
					<td>
						<?php echo CHtml::image($this->module->getRegisteredImage('forum1_s.png'), 'sticky topic', array('style'=>'width:33px;height:34px;vertical-align:middle;')); ?>
					</td>
					<td>
						<?php echo Yii::t('bbii','Sticky topic'); ?>
					</td>
					<td>
						<?php echo CHtml::image($this->module->getRegisteredImage('forum1_g.png'), 'global topic', array('style'=>'width:33px;height:34px;vertical-align:middle;')); ?>
					</td>
					<td>
						<?php echo Yii::t('bbii','Global topic'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo CHtml::image($this->module->getRegisteredImage('forum1_l.png'), 'locked topic', array('style'=>'width:33px;height:34px;vertical-align:middle;')); ?>
					</td>
					<td>
						<?php echo Yii::t('bbii','Locked topic'); ?>
					</td>
					<td>
						<?php echo CHtml::image($this->module->getRegisteredImage('forum1_sl.png'), 'locked sticky topic', array('style'=>'width:33px;height:34px;vertical-align:middle;')); ?>
					</td>
					<td>
						<?php echo Yii::t('bbii','Locked sticky topic'); ?>
					</td>
					<td>
						<?php echo CHtml::image($this->module->getRegisteredImage('forum1_gl.png'), 'locked global topic', array('style'=>'width:33px;height:34px;vertical-align:middle;')); ?>
					</td>
					<td>
						<?php echo Yii::t('bbii','Locked global topic'); ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="statistics">
			<table>
			<caption class="header2">
				<?php echo Yii::t('bbii','Board Statistics'); ?>
			</caption>
			<tr>
				<th><?php echo Yii::t('bbii','Total topics'); ?></th><td><?php echo BbiiTopic::model()->count(); ?></td>
			</tr><tr>
				<th><?php echo Yii::t('bbii','Total posts'); ?></th><td><?php echo BbiiPost::model()->count(); ?></td>
			</tr><tr>
				<th><?php echo Yii::t('bbii','Total members'); ?></th><td><?php echo BbiiMember::model()->count(); ?></td>
			</tr><tr>
				<th><?php echo Yii::t('bbii','Newest member'); ?></th><td><?php $member = BbiiMember::model()->newest()->find(); echo CHtml::link($member->member_name, array('member/view', 'id'=>$member->id)); ?></td>
			</tr><tr>
				<th><?php echo Yii::t('bbii','Visitors today'); ?></th><td><?php echo BbiiSession::model()->count(); ?></td>
			</tr>
			</table>
		</td>
	</tr></table>
</div>
