<div class="contracts form">
	<?php echo $this->Form->create('Contract'); ?>
	<fieldset>
		<legend>
			<?php echo __('契約追加'); ?>
		</legend>
		<?php
		echo $this->Form->input('user_id', array('label' => 'ユーザー名','options' => $users,
				'empty' => '(choose one)'));
		echo $this->Form->input('start_date', array('label' => '契約の初め', 'type' => 'text', 'class' => 'datepicker', 'id' => 'mindate'));
		echo $this->Form->input('end_date', array('label' => '契約の完了', 'type' => 'text', 'class' => 'datepicker', 'id' => 'maxdate'));
		echo $this->Form->input('info', array('label' => '契約情報'));
		?>
	</fieldset>
	<?php echo $this->Form->end(__('追加')); ?>
</div>
<?php echo $this->Html->script('date');?>