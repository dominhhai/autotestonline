<div class="answers view">
<h2><?php  echo __('Answer'); ?></h2>
	<dl>
		<dt><?php echo __('Answer Id'); ?></dt>
		<dd>
			<?php echo h($answer['Answer']['answer_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($answer['Question']['question_id'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['question_id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Path'); ?></dt>
		<dd>
			<?php echo h($answer['Answer']['path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Upload Date'); ?></dt>
		<dd>
			<?php echo h($answer['Answer']['upload_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Answer'), array('action' => 'edit', $answer['Answer']['answer_id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Answer'), array('action' => 'delete', $answer['Answer']['answer_id']), null, __('Are you sure you want to delete # %s?', $answer['Answer']['answer_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
