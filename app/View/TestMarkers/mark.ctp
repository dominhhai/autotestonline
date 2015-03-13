<div>
	<?php 
         echo $test_data['test']['TestTitle'].'<br>';
	 	 echo $test_data['test']['TestSubTitle'].'<br>';
	 	 echo '回答者：　'.$answer_data[0]['testee']['name'].'<br>';
	?>
</div>
<div>
    <?php
        echo $this->Form->create(null,array(
                'name'=>'markForm',
                'url'=>array('controller'=>'test_markers','action'=>'result',$answer_id)));
    ?>
	<table>
	<?php
		echo '<br/><br/>問題と答え一覧<br/><br/>';
		foreach($answer_data[1] as $answer)
		{
			if(($answer['type']=="QW") && isset($test_data['test']['question']['Q('.$answer['number'].')']['list_score']['VINP']))
			{
				echo '<tr><td>';
				echo '<b>問題' . $answer['number'].': '.$test_data['test']['question']['Q('.$answer['number'].')']['content'].'</b><br>';
				echo '</td></tr>';
				$i = 1; // index of answer
				$i_index = 'WR' . $i;
				while (array_key_exists($i_index, $answer)) {
					echo '<tr><td>';
					echo '答え' . $i . ':     ' . $answer[$i_index][0];
					echo '</td></tr>';
					echo '<tr><td>';
					echo '得点: <input type="text" value = "'.$answer[$i_index][1].'" name = "'.$answer['number'].'['. $i .'][score]" maxLength=3 style="width:8px;"><br>';
					echo '</td></tr>';
					// increase answer
					$i ++;
					$i_index = 'WR' . $i;
				}
				if(isset($test_data['test']['question']['Q('.$answer['number'].')']['INS'])) {
					echo '<tr>';
                    echo '<td>コメント: <input type="text" value="'.$answer['INS'].'" name ="'.$answer['number'].'[comment]"></td>';
                    echo '</tr>';
                 }
			}
		}
	?>
	</table>
	<input type="submit" value="サブミット"> 
	</form>
</div>