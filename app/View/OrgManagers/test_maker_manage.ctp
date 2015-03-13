<div class="actions">
	<ul>
		<li><?php 
		echo $this->Html->link(__('出題者追加'), array('action' => 'add_test_maker'));
		?></li>
	</ul>
	<?php 
	echo $this->Form->create('User', array('type' => 'get'));
	echo $this->Form->input('username', array('label' => false, 'required' => false));
	echo $this->Form->end('検索');
	?>
</div>
<div class="clear"></div>
<div class="users index">
	<h2>
		<?php echo __('出題者一覧'); ?>
	</h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('username', 'ユーザー名'); ?></th>
			<th class="actions"><?php echo __('操作'); ?></th>
		</tr>
		<?php foreach ($test_makers as $test_maker): ?>
		<tr>
			<td><?php echo $this->Html->link(($test_maker['User']['id']), array('action' => 'view', $test_maker['User']['id'])); ?>&nbsp;</td>
			<td><?php echo $this->Html->link(($test_maker['User']['username']), array('action' => 'view', $test_maker['User']['id'])); ?>&nbsp;</td>
			<td class="actions">
			<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $test_maker['User']['id'])); ?>
			<?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $test_maker['User']['id']), null, __('%s ユーザーを削除しますが、よろしいですか？', $test_maker['User']['firstname'].' '.$test_maker['User']['lastname'])); ?>
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

