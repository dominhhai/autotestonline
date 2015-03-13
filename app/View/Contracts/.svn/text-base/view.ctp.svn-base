<div class="Contract view">
<h2><?php  echo __('契約管理情報'); ?></h2>
	<table class="view_table">
		<tr>
			<th class="view_head"><?php echo "団体"?></th>
			<th><?php echo $contract['Contract']['info']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "担当者"?></th>
			<th><?php echo $this->Html->link($contract['Contract']['username'], array('controller' => 'sys_managers', 'action' => 'view', $contract['Contract']['user_id']))?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "契約の初め"?></th>
			<th><?php echo $contract['Contract']['start_date']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "契約の完了"?></th>
			<th><?php echo $contract['Contract']['end_date']?></th>
		</tr>
	</table>
</div>
<div class = "action">
	<?php
	echo $this->Html->link('戻る', array('action' => 'index'), array('class' => 'button'));
	echo $this->Html->link('編集', array('action' => 'edit', $contract['Contract']['contract_id']), array('class' => 'button'));
	echo $this->Form->postLink(__('削除'), array('action' => 'delete', $contract['Contract']['contract_id']), array('class' => 'button'), __('%s の契約を削除しますが、よろしいですか？', $contract['Contract']['info']));
	?>
</div>
