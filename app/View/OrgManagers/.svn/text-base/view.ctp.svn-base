<div class="orgManagers view">
<h2><?php  echo __('ユーザー情報'); ?></h2>
	<table class="view_table">
		<tr>
			<th class="view_head"><?php echo "ユーザー名"?></th>
			<th><?php echo $user['User']['username']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "名"?></th>
			<th><?php echo $user['User']['firstname']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "姓"?></th>
			<th><?php echo $user['User']['lastname']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "アドレス"?></th>
			<th><?php echo $user['User']['address']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "電話番号"?></th>
			<th><?php echo $user['User']['phone']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "銀行口座"?></th>
			<th><?php echo $user['User']['bank_account']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "ユーザーの情報"?></th>
			<th><?php echo $user['User']['info']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "持ち場"?></th>
			<th><?php echo User::$kind[$user['User']['kind']]?></th>
		</tr>
	</table>
</div>
<div class = "action">
	<?php
	if($user['User']['kind'] == 3) {
		echo $this->Html->link('戻る', array('action' => 'test_marker_manage'), array('class' => 'button'));
	} elseif ($user['User']['kind'] == 4) {
		echo $this->Html->link('戻る', array('action' => 'test_maker_manage'), array('class' => 'button'));
	}
	echo $this->Html->link('編集', array('action' => 'edit', $user['User']['id']), array('class' => 'button'));
	echo $this->Form->postLink(__('削除'), array('action' => 'delete', $user['User']['id']), array('class' => 'button'), __('%s ユーザーを削除しますが、よろしいですか？', $user['User']['firstname'].' '.$user['User']['lastname']));
	?>
</div>
