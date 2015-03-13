<h2>
	<?php echo $test.'の結果：'?>
</h2>
<p>
	<?php
	$submit = $data[0]['submittime'];
	echo 'サブミット時間：'.date("Y-m-d H:i:s", mktime($submit[3],$submit[4],$submit[5],$submit[1],$submit[2],$submit[0]));
	?>
</p>
<div>
	<table style="width: 40%">
		<tr>
			<th class="head">問題</th>
			<th class="head">点</th>
		</tr>
		<?php 
		foreach ($data[1] as $score):
		?>
		<tr>
			<td><?php echo '問題 '. $score['number']?></td>
			<td><?php echo $score['score'][0]?></td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td>統計</td>
			<td><?php echo $data[2]?></td>
		</tr>
	</table>
</div>
