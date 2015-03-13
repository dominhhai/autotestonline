<?php
	if(isset($test_data['test']['TestTitle']))
	echo $test_data['test']['TestTitle'].'<br>';
	if(isset($test_data['test']['TestSubTitle']))
	echo $test_data['test']['TestSubTitle'].'<br>';
	$question_list= $test_data['test']['question'];
?>
<div class="login-date">
		トータル時間: <span class="min">
		<?php
			$tmp = intval($testtime/60);
			echo $tmp;
		?>
		</span>分 : <span class="sec">
		<?php 
		 echo $testtime - $tmp*60;
		?>
		</span>秒
</div>
<?php 
	if($test_data['test']['TestType']=='Unfix')
	{
		echo '<select class = "listquestion">';
		echo '<option value ="0"></option>';
		for($i=1;$i<=count($question_list);$i++)
		{
			echo '<option value="'.$i.'">Question '.$i.'</option>';
		}
		echo '</select>';
	}
?>
<?php 
	echo '<form name="testForm" action="../TestManages/result" method="post">';
	echo '<label id="total" style="display:none">'.count($question_list).'</label>'
?>
<div class="test_content">
	<?php 
		for($i=1;$i<=count($question_list);$i++)
		{
			if($i==1) echo '<div id="content1">';
			else echo '<div id="content'.$i.'" style="display:none">';
			echo 'Question '.$i.':';
			echo $question_list['Q('.$i.')']['content'].'<br>';
			if(isset($question_list['Q('.$i.')']['image_path']))
			{
				echo '<img src="'.$question_list['Q('.$i.')']['image_path'].'"><br>';
			}
			if($question_list['Q('.$i.')']['type']=="QS")
			{
				for($j=1;$j<=count($question_list['Q('.$i.')']['answer_list']);$j++)
				{
					echo '<input value="S('.$j.')" name="question[Q('.$i.')][result][]" type="checkbox">'.$question_list['Q('.$i.')']['answer_list']['S('.$j.')']['content'].'<br/>';
					if(isset($question_list['Q('.$i.')']['answer_list']['S('.$j.')']['image_path']))
					echo '<img src="'.$question_list['Q('.$i.')']['answer_list']['S('.$j.')']['image_path'].'"><br>';
				}
			}
			else
			{
				echo '<textarea name="question[Q('.$i.')][result][]"></textarea>';
			}
			// thoi gian lam cho moi cau test
			echo '<input type="" name = "question[Q('.$i.')][time]" value = "0" id = "testtime'.$i.'">';
			echo '</div>';
		}
	?>
	<?php 
		echo $this->Form->button('next',array(
			'type'=>'button',
			'id'=>'next'
			));
	?>
</div>
<?php echo $this->Form->button('Submit',array('type'=>'submit'));?>
<?php echo $this->Html->script('test');?>
</form>
<script>

</script>