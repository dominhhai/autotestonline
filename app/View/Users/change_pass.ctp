<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('パスワード変更'); ?></legend>
	<?php
		echo $this->Form->input('old_password', array('label' => '古いパスワード', 'type' => 'password'));
		echo $this->Form->input('password', array('label' => 'パスワード'));
		echo $this->Form->input('re_password', array('label' => '確認パスワード', 'type' => 'password'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('変更')); ?>
</div>
