<div class="actions">
	<h3>
		<?php echo __('契約管理'); ?>
	</h3>
	<?php 
	echo $this->Form->create('Contract', array('type' => 'get'));
	echo $this->Form->input('info', array('label' => false, 'required' => false, 'type' => 'text'));
	echo $this->Form->end('検索');
	?>
</div>
<div class="clear"></div>
<div class="contracts index">
	<h2><?php echo __('契約一覧'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('contract_id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('info', '団体'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id', '担当者'); ?></th>
			<th><?php echo $this->Paginator->sort('start_date', '契約の初め'); ?></th>
			<th><?php echo $this->Paginator->sort('end_date', '契約の完了'); ?></th>
			<th class="actions"><?php echo __('操作'); ?></th>
	</tr>
	<?php foreach ($contracts as $contract): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($contract['Contract']['contract_id'], array('controller' => 'contracts', 'action' => 'view', $contract['Contract']['contract_id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contract['Contract']['info'], array('controller' => 'contracts', 'action' => 'view', $contract['Contract']['contract_id'])); ?>
		</td>
		<td>
			<?php 
			echo $this->Html->link($contract['Contract']['username'], array('controller' => 'sys_managers', 'action' => 'view', $contract['Contract']['user_id'])); ?>
		</td>
		<td><?php echo h($contract['Contract']['start_date']); ?>&nbsp;</td>
		<td><?php echo h($contract['Contract']['end_date']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $contract['Contract']['contract_id'])); ?>
			<?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $contract['Contract']['contract_id']), null, __('%s の契約を削除しますが、よろしいですか？', $contract['Contract']['info'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
		<?php
		echo $this->Paginator->counter(array(
				'format' => __('{:page}/{:pages}ページ')
		));
		?>
	</p>
	<div class="paging">
		<?php
		echo $this->Paginator->prev('< ' . __('前に'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('次に') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
</div>
