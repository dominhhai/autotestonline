<?php
//	echo '<pre>';
//	print_r($test_data);
//	echo '</pre>';
	if(isset($test_data['test']['TestTitle']))
	echo $test_data['test']['TestTitle'].'<br>';
	if(isset($test_data['test']['TestSubTitle']))
	echo $test_data['test']['TestSubTitle'].'<br>';
	$question_list= $test_data['test']['question'];
?>
<div class="login-date">
		テスト時間: <span class="min">
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
			echo '<option value="'.$i.'">問題 '.$i.'</option>';
		}
		echo '</select>';
	}
?>
<?php 
	echo '<form name="testForm" action="../TestTees/result" method="post">';
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
<?php echo $this->Form->button('サブミット',array('type'=>'submit'));?>
</form>
<script type="text/javascript">
index=1;
total = parseInt($('#total').text());
$(document).ready(function(){
	$('#next').click(function(){
		if(index<total){
			var tmp='#content'+index;
			$(tmp).hide();
			index=index+1;
			var tmp='#content'+index;
			$(tmp).show();
                        if(index == total)
                            {
                                $('#next').hide();
                            }
		}
	});
	$('.listquestion').change(function(){
		var tmp = parseInt($('.listquestion').val());
		if(tmp!=0)
		{
			$('#content'+index).hide();
			index = tmp;
			$('#content'+index).show();
                        if(index == total) $('#next').hide();
                        else $('#next').show();
		}
	});
});
function countdown() {
    var m = $('.min');
    var s = $('.sec');  
    if(m.length == 0 && parseInt(s.html()) <= 0) {
        $('.login-date').html('Timer Complete.');
        document.testForm.submit();return false; 
    }
    if(parseInt(s.html()) <= 0) {
        m.html(parseInt(m.html()-1));   
        s.html(60);
    }
    if(parseInt(m.html()) <= 0) {
        $('.login-date').html('TIME: <span class="sec">59</span> seconds.'); 
    }
    s.html(parseInt(s.html()-1));
}
function countup() {
    var t=parseInt($('#testtime'+index).val());
    $('#testtime'+index).val(t+1);
    $('.testtimeview'+index).html(t+1);
}
setInterval('countdown()',1000);
setInterval('countup()',1000);
</script>