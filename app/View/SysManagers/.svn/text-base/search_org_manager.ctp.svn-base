<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li>
			<?php 
				echo $this->Html->link(__('New User'), array('action' => 'add')); 
			?>
		</li>
		<li>
		<?php 
			echo $this->Form->create('User', array('type' => 'get'));
			echo $this->Form->input('username', array('label' => false));
			echo $this->Form->end('検索');		
		?>
		</li>
	</ul>
</div>

<div class="users index">
	<h2><?php echo __('Users'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($org_managers as $org_manager): ?>
	<tr>
		<td><?php echo $this->Html->link(($org_manager['User']['id']), array('action' => 'view')); ?>&nbsp;</td>
		<td><?php echo $this->Html->link(($org_manager['User']['username']), array('action' => 'view')); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $org_manager['User']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $org_manager['User']['id']), null, __('Are you sure you want to delete # %s?', $org_manager['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}')
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

