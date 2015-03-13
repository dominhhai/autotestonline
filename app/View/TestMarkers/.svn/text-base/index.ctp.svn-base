<h2>
    <?php
    if(isset($orgFirstName)) echo '団体担当者：'.$orgFirstName;
    if(isset($orgLastName)) echo $orgLastName;
    ?>
</h2>
<label>テスト選択</label>
<select id="testid">
	<option value="0"></option>
	<?php 
	foreach($test_list as $test)
	{
		echo '<option value="'.$test['Answer']['question_id'].'">テスト'.$test['Answer']['question_id'].'</option>';
	}
	?>
</select>
<div id="test_answer">

</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#testid').change(function(){
			var url = '<?php echo $this->Html->url(array('controller' => 'test_markers','action' => 'getAnswer'));?>' + '/'+ $("#testid").val();
			$.ajax({
				url : url,
				success : function(data){
					$('#test_answer').html(data);
				}
			});
		});
});
</script>