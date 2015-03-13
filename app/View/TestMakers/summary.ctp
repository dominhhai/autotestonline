<h3>テストの結果</h3>
<table >
<?php foreach ($answers as $answer) :?>
	<tr>
		<th><?php echo $answer[0]['testee'][0];?></th>
		<th><?php echo $answer[2];?></th>
	</tr>
<?php endforeach;?>
</table>
<table>
	<tr>
		<th>回答者合計</th>
		<th><?php echo $sum['total']?></th>
	</tr>
	<tr>
		<th>平均点</th>
		<th><?php echo $sum['average']?></th>
	</tr>
	<tr>
		<th>最高点</th>
		<th><?php echo $sum['max']?></th>
	</tr>
	<tr>
		<th>最低点</th>
		<th><?php echo $sum['min']?></th>
	</tr>
</table>
<div>
	<?php echo $this->Html->link('戻る', array('action' => 'view', $sum['test_id']), array('class' => 'button'));?>
</div>