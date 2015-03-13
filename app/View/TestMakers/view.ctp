<div class="question view">
	<h2>
		<?php  echo __('テスト情報'); ?>
	</h2>
	<table class="view_table">
		<tr>
			<th class="view_head"><?php echo "ファイル名"?>
			</th>
			<th><?php echo Common::getFileName($question['Question']['path'])?>
			</th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "作成日"?>
			</th>
			<th><?php echo $question['Question']['created']?>
			</th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "テスト日"?>
			</th>
			<th><?php echo $question['Question']['start_date']?>
			</th>
		</tr>
		<tr>
			<th class="view_head"><?php echo "ステータス"?>
			</th>
			<th><?php 
					echo Question::$status[$question['Question']['status']].'<br/>';
				?></th>
		</tr>

		<tr>
			<th class="view_head"><?php echo "テストのリンク"?>
			</th>
			<th><?php echo $question['Question']['test_link']?>
			</th>
		</tr>
	</table>
</div>
<div class="action">
	<?php
	echo $this->Html->link('戻る', array('action' => 'index'), array('class' => 'button'));
	echo $this->Html->link('シミュレーション', array('action' => 'simulation', $question['Question']['question_id']), array('class' => 'button'));
	if($question['Question']['status'] == 0){
		echo $this->Form->postLink('削除', array('action' => 'delete', $question['Question']['question_id']), array('class' => 'button'), __('%sを削除しますが、よろしいですか？', Common::getFileName($question['Question']['path'])));
	}
	?>
</div>
