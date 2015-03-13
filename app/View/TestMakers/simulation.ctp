<?php
	if(isset($test_data['test']['TestTitle']))
	echo $test_data['test']['TestTitle'].'<br>';
	if(isset($test_data['test']['TestSubTitle']))
	echo $test_data['test']['TestSubTitle'].'<br>';
	$question_list= $test_data['test']['question'];
//        echo '<pre>';
//        print_r($question_list);
//        echo '</pre>';
?>
<?php 
	if($test_data['test']['TestType']=='Unfix')
	{
		echo '<select class = "listquestion">';
		echo '<option value ="0"></option>';
		for($i=1;$i<=count($question_list);$i++)
		{
			echo '<option value="'.$i.'">問題 '.$i.'</option>';
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
			echo '<b>問題 '.$i.': '.$question_list['Q('.$i.')']['content'].'</b><br>';
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
                            
                            for($j=1;$j<=count($question_list['Q('.$i.')']['character_limit']);$j++) 
                            {
				echo '<textarea name="question[Q('.$i.')][result][]"';
                                if(isset($question_list['Q('.$i.')']['character_limit']['WR('.$j.')']))
                                {
                                    echo 'maxlength = "'.$question_list['Q('.$i.')']['character_limit']['WR('.$j.')'].'"';
                                }
                                echo '></textarea><br>';
                            }
                            
			}
			// thoi gian lam cho moi cau test
			echo '問題の時間: <span class = "testtimeview'.$i.'"></span>秒';
			echo '<input type="hidden" name = "question[Q('.$i.')][time]" value = "0" id = "testtime'.$i.'">';
			echo '</div>';
		}
	?>
	<?php 
		echo $this->Form->button('次に',array(
			'type'=>'button',
			'id'=>'next'
			));
	?>
</div>
<?php echo $this->Html->link('キャンセル', array('action' => 'view', $test_id), array('class' => 'button'));?>
<?php echo $this->Html->script('test');?>
</form>
