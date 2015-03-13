<div class="SysManagers form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('ユーザー編集'); ?></legend>
	<?php
		echo $this->Form->input('username', array('label' => 'ユーザー名', 'disabled' => 'disabled'));
		echo $this->Form->input('firstname', array('label' => '名'));
		echo $this->Form->input('lastname', array('label' => '姓'));
		echo $this->Form->input('address', array('label' => 'アドレス'));
		echo $this->Form->input('phone', array('label' => '電話番号'));
		echo $this->Form->input('bank_account', array('label' => '銀行口座'));
		echo $this->Form->input('info', array('label' => '他のインフォメーション'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('編集')); ?>
</div>
