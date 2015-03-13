<div class="test answers">
	<h2>
		<?php echo __('テスト一覧'); ?>
	</h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo "番号"?></th>
			<th><?php echo "テストID"?></th>
			<th><?php echo "回答者" ?></th>
			<th><?php echo "時間" ?></th>
			<th><?php echo "採点" ?></th>
			<th class="actions"><?php echo "ステータス" ?></th>
		</tr>
		
		<?php 
		$i=1;
		foreach ($answer_list as $answer): ?>
		<tr>
			<td><?php echo $i;?>&nbsp;</td>
			<td>	
				<?php 
					echo $answer['Answer']['question_id'];
				?>
				&nbsp;
			</td>
			<td>	
				<?php 
					echo $answer['Answer']['tester']; 
				?>
				&nbsp;
			</td>
			<td>	
				<?php 
					echo $answer['Answer']['upload_date']
				?>
				&nbsp;
			</td>
			<td>	
				<?php 
					echo $this->Html->link(__('採点する'), array('action' => 'mark', $answer['Answer']['answer_id']));
				?>
				&nbsp;
			</td>
			<td class="actions">
				<?php 
					if($answer['Answer']['is_markered']==1){
						echo $this->Html->image("v.png", array('alt' => '採点した'));
					} else {
						echo $this->Html->image("x.png", array('alt' => 'まだ採点しない'));
					}
				  ?>
			</td>
		</tr>
		<?php 
		$i++;
		endforeach; ?>
	</table>
</div>