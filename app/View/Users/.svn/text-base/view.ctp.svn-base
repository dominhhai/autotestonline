<div class="users view">
<h2><?php  echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fisrtname'); ?></dt>
		<dd>
			<?php echo h($user['User']['fisrtname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lastname'); ?></dt>
		<dd>
			<?php echo h($user['User']['lastname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bank Account'); ?></dt>
		<dd>
			<?php echo h($user['User']['bank_account']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Info'); ?></dt>
		<dd>
			<?php echo h($user['User']['info']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Kind'); ?></dt>
		<dd>
			<?php echo h($user['User']['kind']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contracts'), array('controller' => 'contracts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contract'), array('controller' => 'contracts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Org Managers'), array('controller' => 'org_managers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Org Manager'), array('controller' => 'org_managers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Contracts'); ?></h3>
	<?php if (!empty($user['Contract'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Contract Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Start Date'); ?></th>
		<th><?php echo __('End Date'); ?></th>
		<th><?php echo __('Info'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Contract'] as $contract): ?>
		<tr>
			<td><?php echo $contract['contract_id']; ?></td>
			<td><?php echo $contract['user_id']; ?></td>
			<td><?php echo $contract['start_date']; ?></td>
			<td><?php echo $contract['end_date']; ?></td>
			<td><?php echo $contract['info']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'contracts', 'action' => 'view', $contract['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'contracts', 'action' => 'edit', $contract['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'contracts', 'action' => 'delete', $contract['id']), null, __('Are you sure you want to delete # %s?', $contract['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Contract'), array('controller' => 'contracts', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Org Managers'); ?></h3>
	<?php if (!empty($user['OrgManager'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Org Manager Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['OrgManager'] as $orgManager): ?>
		<tr>
			<td><?php echo $orgManager['org_manager_id']; ?></td>
			<td><?php echo $orgManager['user_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'org_managers', 'action' => 'view', $orgManager['org_manager_id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'org_managers', 'action' => 'edit', $orgManager['org_manager_id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'org_managers', 'action' => 'delete', $orgManager['org_manager_id']), null, __('Are you sure you want to delete # %s?', $orgManager['org_manager_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Org Manager'), array('controller' => 'org_managers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Questions'); ?></h3>
	<?php if (!empty($user['Question'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Question Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Path'); ?></th>
		<th><?php echo __('Test Link'); ?></th>
		<th><?php echo __('Start Date'); ?></th>
		<th><?php echo __('End Date'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Question'] as $question): ?>
		<tr>
			<td><?php echo $question['question_id']; ?></td>
			<td><?php echo $question['user_id']; ?></td>
			<td><?php echo $question['path']; ?></td>
			<td><?php echo $question['test_link']; ?></td>
			<td><?php echo $question['start_date']; ?></td>
			<td><?php echo $question['end_date']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'questions', 'action' => 'view', $question['question_id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'questions', 'action' => 'edit', $question['question_id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'questions', 'action' => 'delete', $question['question_id']), null, __('Are you sure you want to delete # %s?', $question['question_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
