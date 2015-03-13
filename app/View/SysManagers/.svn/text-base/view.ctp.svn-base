<div class="orgManagers view">
<h2><?php  echo __('ユーザー情報'); ?></h2>
	<table class="view_table">
		<tr>
			<th class="view_head"><?php echo "団体"?></th>
			<th>
				<?php
					echo $user['Contract'][0]['info'];
				?>
			</th>
		</tr>
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
			<th class="view_head"><?php echo "他の情報"?></th>
			<th><?php echo $user['User']['info']?></th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "ステータス"?></th>
			<th><?php
			if($user['User']['del_flg'] == 1) {
				echo 'アカウントが有効化されていません。';
				echo $this->Html->link(__('契約時間を延長する'), array('controller' => 'contracts','action' => 'edit', $contract['Contract']['contract_id']));
			} else {
				echo 'アカウントが有効しています。';
				//echo $this->Form->postLink(__('無効にする'), array('action' => 'disable', $user['User']['id']), null, __('%s のユーザーアカウントを無効にする？', $user['User']['username']));
			}
			?></th>
		</tr>
	</table>
</div>
<div class = "action">
	<?php
	echo $this->Html->link('戻る', array('action' => 'index'), array('class' => 'button'));
	echo $this->Html->link('編集', array('action' => 'edit', $user['User']['id']), array('class' => 'button'));
	echo $this->Form->postLink(__('削除'), array('action' => 'delete', $user['User']['id']), array('class' => 'button'), __('%s ユーザーを削除しますが、よろしいですか？', $user['User']['username']));
	?>
</div>
