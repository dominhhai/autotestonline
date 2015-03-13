<div class="actions">
	<h3>
		<?php echo __('テスト管理画面'); ?>
	</h3>
	<ul>
		<li><?php 
		echo $this->Form->create('Question', array('type' => 'get'));
		echo $this->Form->select('status',
				array(
						0 => '未行い',
						1 => '完了',
						2 => '実装中',
				),
				array(
						'empty' => 'ステータス',
						'label' => false,
						'required' => false
				)
		);
		echo $this->Form->end('検索');
		?></li>
	</ul>
</div>
<div class="clear"></div>
<div class="users index">
	<h2>
		<?php echo __('テスト一覧'); ?>
	</h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('question_id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('path', 'ファイルのパス―'); ?></th>
			<th><?php echo $this->Paginator->sort('created', '作成日'); ?></th>
			<th><?php echo $this->Paginator->sort('status', 'ステータス'); ?></th>
			<th class="actions"><?php echo ''; ?></th>
		</tr>
		<?php foreach ($questions as $question): ?>
		<tr>
			<td><?php echo $question['Question']['question_id']?>&nbsp;</td>
			<td>	
				<?php 
					$path = $question['Question']['path'];
					echo Common::getFileName($path); 
				?>
				&nbsp;
			</td>
			<td>	
				<?php 
					echo $question['Question']['created']; 
				?>
				&nbsp;
			</td>
			<td>	
				<?php 
					echo Question::$status[$question['Question']['status']]; 
				?>
				&nbsp;
			</td>
			<td class="actions">
				<?php 
				if($question['Question']['status'] == 1){
					echo $this->Html->link(Question::$actions[$question['Question']['status']], array('action' => 'statistic', $question['Question']['question_id']));
				} 
				?>
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

