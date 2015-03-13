	<ul>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>

<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('fisrtname');
		echo $this->Form->input('lastname');
		echo $this->Form->input('bank_account');
		echo $this->Form->input('info');
		echo $this->Form->input('kind');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
