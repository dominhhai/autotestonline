<div class="SysManagers form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('出題者追加'); ?></legend>
	<?php
		echo $this->Form->input('Contract.info', array('type' => 'text', 'label' => '団体名'));
		echo $this->Form->input('username', array('label' => 'ユーザー名'));
		echo $this->Form->input('password', array('label' => 'パスワード'));
		echo $this->Form->input('re_password', array('label' => '確認パスワード', 'type' => 'password'));
		echo $this->Form->input('firstname', array('label' => '名'));
		echo $this->Form->input('lastname', array('label' => '姓'));
		echo $this->Form->input('address', array('label' => 'アドレス'));
		echo $this->Form->input('phone', array('label' => '電話番号'));
		echo $this->Form->input('bank_account', array('label' => '銀行口座'));
		echo $this->Form->input('Contract.start_date', array('label' => '契約の初め', 'type' => 'text', 'class' => 'datepicker', 'id' => 'mindate'));
		echo $this->Form->input('Contract.end_date', array('label' => '契約の完了', 'type' => 'text', 'class' => 'datepicker', 'id' => 'maxdate'));
		echo $this->Form->input('info', array('label' => '他のインフォメーション'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('追加')); ?>
</div>
<?php echo $this->Html->script('date');?>