<div style="color: red">		
	    <?php		
	        $error = $this->Session->read('error');		
	        if(isset($error))		
	            echo $error;		
	    ?>		
</div>
<div>
	<h2 class="title">
		テスト名:
		<?php 
		if(isset($test_data['test']['TestTitle']))
		{
			echo $test_data['test']['TestTitle'].'<br>';
		}
		if(isset($test_data['test']['TestSubTitle']))
		{
			echo $test_data['test']['TestSubTitle'].'<br>';
		}
		?>
	</h2>
	<?php if(!isset($answer['Answer']['is_markered'])):?>
	<div class="start-time">
		スタート時間 :
		<?php 
		echo date("d-m-Y:H:i:s",$start_time);
		?>
	</div>
	<div>
		<?php if(isset($end_time))
		{
			echo '終わる時間 :';
			echo date("d-m-Y:H:i:s",$end_time);
		}
		?>
	</div>
	<br> <br>
	<div class="test_rule">
		スタート時間の後にテストできます。<br> 選択問題に、二つ答え以上を選択できます。<br> テストを完了したら、予見の結果が見れます。<br>
		採点してから、結果がメールを送ります。<br>
		<div align="right">
			<?php
			echo $this->Html->link(
					'テストスタート',
					array('controller' => 'test_tees', 'action' => 'test'),
					array('class' => 'button')
			);
			?>
		</div>
	</div>
</div>
<?php 
elseif(isset($answer['Answer']['is_markered']) && $answer['Answer']['is_markered'] != 0):
?>
<div>
	<h2>テストは終わりました。テストの結果もうありますした。</h2>
	<div align="right">
		<?php 
		echo $this->Html->link('結果', array('controller' => 'test_tees', 'action' => 'statistic'), array('class' => 'button'));
		?>
	</div>
</div>
<?php 
elseif(isset($answer['Answer']['is_markered']) && $answer['Answer']['is_markered'] == 0):
?>
<div>
<h2>テストは終わりました。テストの結果まだありません。</h2>
</div>
<?php
endif;
?>
