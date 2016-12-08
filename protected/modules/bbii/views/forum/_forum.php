<?php
/* @var $this ForumController */
/* @var $data BbiiForum */
?>

<?php if($data->type): ?>
	<div class="forum">
	<div class="forum-cell">
		<?php 
		if(!isset($data->last_post_id) || $this->forumIsRead($data->id)) {
			if($data->locked) {
				echo CHtml::image($this->module->getRegisteredImage('forum2_l.png'), 'locked forum');
			} elseif($data->moderated) {
				echo CHtml::image($this->module->getRegisteredImage('forum2_m.png'), 'moderated forum');
			} elseif(!$data->public) {
				echo CHtml::image($this->module->getRegisteredImage('forum2_p.png'), 'private forum');
			} else {
				echo CHtml::image($this->module->getRegisteredImage('forum2.png'), 'forum');
			}
		} else {
			if($data->locked) {
				echo CHtml::image($this->module->getRegisteredImage('forum1_l.png'), 'locked forum');
			} elseif($data->moderated) {
				echo CHtml::image($this->module->getRegisteredImage('forum1_m.png'), 'moderated forum');
			} elseif(!$data->public) {
				echo CHtml::image($this->module->getRegisteredImage('forum1_p.png'), 'private forum');
			} else {
				echo CHtml::image($this->module->getRegisteredImage('forum1.png'), 'forum');
			}
		}
		?>
	</div>
	<div class="forum-cell main">
		<div class="header2">
			<?php echo CHtml::link(CHtml::encode($data->name), array('forum', 'id'=>$data->id)); ?>
		</div>
		<div class="header4">
			<?php echo CHtml::encode($data->subtitle); ?>
		</div>
	</div>
	<div class="forum-cell center">
		<?php echo CHtml::encode($data->num_posts); ?><br>
		<?php echo CHtml::encode($data->getAttributeLabel('num_posts')); ?>
	</div>
	<div class="forum-cell center">
		<?php echo CHtml::encode($data->num_topics); ?><br>
		<?php echo CHtml::encode($data->getAttributeLabel('num_topics')); ?>
	</div>
	<div class="forum-cell last-cell">
		<?php if($data->last_post_id && $data->lastPost) {
			echo CHtml::encode($data->lastPost->poster->member_name);
			echo CHtml::link(CHtml::image($this->module->getRegisteredImage('next.png'), 'next', array('style'=>'margin-left:5px;')), array('topic', 'id'=>$data->lastPost->topic_id, 'nav'=>'last'));
			echo '<br>';
			echo DateTimeCalculation::long($data->lastPost->create_time);
		} else {
			echo Yii::t('bbii', 'No posts');
		}
		?>
	</div>


<?php else: ?>
	<div class="forum-category">
		<div class="header2">
			<?php echo CHtml::encode($data->name); ?>
		</div>
		<div class="header4">
			<?php echo CHtml::encode($data->subtitle); ?>
		</div>
<?php endif; ?>
</div>