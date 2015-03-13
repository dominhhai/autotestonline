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
                'url'=>array('controller'=>'test_makers','action'=>'result',$answer_id)));
    ?>
	<table>
	<?php
		echo '<br/><br/>問題と答え一覧<br/><br/>';
		
		foreach($answer_data[1] as $answer)
		{
			$isVINP = isset($test_data['test']['question']['Q('.$answer['number'].')']['list_score']['VINP']);
			// display question
			echo '<tr><td>';
			echo '<b>問題' . $answer['number'].': '.$test_data['test']['question']['Q('.$answer['number'].')']['content'].'</b><br>';
			echo '</td></tr>';
			// time limit
			if (isset ($test_data['test']['question']['Q('.$answer['number'].')']['LM'])) {
				// convert in to s
				$question_data = $test_data['test']['question']['Q('.$answer['number'].')'];
				$question_time = array ('type' => "TRI", 'time1' => "5", 'time2' => "10");
					$question_time['type'] = $question_data['LM']['type'];
					if (($question_time['type'] == 'TRI') ||  ($question_time['type'] == 'REC')) {
						$question_time['time1'] = $question_data['LM']['time']['value'];
						if ($question_data['LM']['time']['unit'] == 'm') {
							$question_time['time1'] = $question_time['time1'] * 60;
						} else if ($question_data['LM']['time']['unit'] == 'h') {
							$question_time['time1'] = $question_time['time1'] * 60 * 60;
						}
					} else {
						$question_time['time1'] = $question_data['LM']['time1']['value'];
						if ($question_data['LM']['time1']['unit'] == 'm') {
							$question_time['time1'] = $question_time['time1'] * 60;
						} else if ($question_data['LM']['time1']['unit'] == 'h') {
							$question_time['time1'] = $question_time['time1'] * 60 * 60;
						}
						$question_time['time2'] = $question_data['LM']['time2']['value'];
						if ($question_data['LM']['time2']['unit'] == 'm') {
							$question_time['time2'] = $question_time['time1'] * 60;
						} else if ($question_data['LM']['time2']['unit'] == 'h') {
							$question_time['time2'] = $question_time['time2'] * 60 * 60;
						}
					}
				echo '<tr>';
				// type
				echo '<td>';
				echo '時間の種類：' . $question_data['LM']['type'];
				echo '</td>';
				// time
				echo '<td>';
				if (($question_time['type'] == 'TRI') ||  ($question_time['type'] == 'REC')) {
					echo '時間：' . $question_time['time1'] .'秒';
				} else {
					echo '時間1：' . $question_time['time1'] . '秒    ' . '時間２：' . $question_time['time2'] . '秒';
				}
				echo '</td>';
				echo '</tr>';
			}
			// time for answer
				echo '<tr><td>';
				echo 'かかる時間：' .$answer['score'][1]. '秒';
				echo '</td></tr>';
				echo '<tr><td>';
				echo '答え一覧：';
				echo '</td></tr>';
			// display answer
			if($answer['type']=="QW") // QW
			{
				$i = 1; // index of answer
				$i_index = 'WR' . $i;
				while (array_key_exists($i_index, $answer)) {
					// answer
					echo '<tr><td>';
					echo '答え' . $i . ':     ' . $answer[$i_index][0];
					echo '</td></tr>';
					echo '<tr><td>';
					// score
					if ($isVINP) {
						echo '得点: <input type="text" value = "'.$answer[$i_index][1].'" name = "'.$answer['number'].'['. $i .'][score]" maxLength=3 style="width:8px;"><br>';
					} else {
						echo '得点：　'.$answer[$i_index][1];
					}
					echo '</td></tr>';
					// increase answer
					$i ++;
					$i_index = 'WR' . $i;
				}
			} else { // QS
				// answer
				 // TODO using test_data and answer_data $test_data['test']['question']['Q('.$answer['number'].')']
				$num_an = count($test_data['test']['question']['Q('.$answer['number'].')']['answer_list']);
				for($j = 1; $j <= $num_an; $j++) {
					$isSelected = in_array ('S('.$j.')', $answer); 
					//print_r($answer);
					echo '<tr><td>';
					if ($isSelected) {
						echo '<p style="color:blue;">';
					}
					echo $j.': '.$test_data['test']['question']['Q('.$answer['number'].')']['answer_list']['S('.($j).')']['content'];
					if ($isSelected) {
						echo '</p>';
					}
					echo '</td></tr>';
				}
				// score
				echo '<tr><td>';
				if ($isVINP) {
					echo '得点: <input type="text" value = "'.$answer['score'][0].'" name = "'.$answer['number'].'[score]" maxLength=3 style="width:8px;"><br>';
				} else {
					echo '得点：　'.$answer['score'][0];
				}
				echo '</td></tr>';
			}
			// display comment box
			if(isset($test_data['test']['question']['Q('.$answer['number'].')']['INS'])) {
				echo '<tr>';
                echo '<td>コメント: <input type="text" value="'.$answer['INS'].'" name ="'.$answer['number'].'[comment]"></td>';
             	echo '</tr>';
             }
		}
	?>
	</table>
	<br/>
	<p><b>合計得点：　 <?php echo $answer_data[2]; ?></b></p>
	<br/>
	<?php echo $this->Form->end("サブミット");?> 
	</form>
</div>