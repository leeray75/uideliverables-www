<?php
/* @var $this ModeratorController */
/* @var $model BbiiPost */
?>
<table>
<tr>
	<th style="width:150px;"><?php echo CHtml::activeLabel($model, 'user_id'); ?></th>
	<td><?php echo CHtml::encode($model->poster->member_name); ?></td>
</tr>
<tr>
	<th><?php echo CHtml::activeLabel($model, 'subject'); ?></th>
	<td><?php echo CHtml::encode($model->subject); ?></td>
</tr>
<tr>
	<th><?php echo CHtml::activeLabel($model, 'create_time'); ?></th>
	<td><?php echo DateTimeCalculation::full($model->create_time); ?></td>
</tr>
<tr>
	<td colspan="2"><hr><?php echo $model->content; ?></td>
</tr>
</table>