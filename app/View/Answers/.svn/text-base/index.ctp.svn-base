<div class="answers index">
	<h2><?php echo __('Answers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('answer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('question_id'); ?></th>
			<th><?php echo $this->Paginator->sort('path'); ?></th>
			<th><?php echo $this->Paginator->sort('upload_date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($answers as $answer): ?>
	<tr>
		<td><?php echo h($answer['Answer']['answer_id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($answer['Question']['question_id'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['question_id'])); ?>
		</td>
		<td><?php echo h($answer['Answer']['path']); ?>&nbsp;</td>
		<td><?php echo h($answer['Answer']['upload_date']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $answer['Answer']['answer_id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $answer['Answer']['answer_id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $answer['Answer']['answer_id']), null, __('Are you sure you want to delete # %s?', $answer['Answer']['answer_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Answer'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
