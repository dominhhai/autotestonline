<div>
    <br>
    今からの1回テストのコスト：<?php echo $test_cost?> ベトナムドン<br>
    <br>
    <div>
    <?php
        echo $this->Html->link('1回テストのコストを変更',array('controller'=>'sys_managers','action'=>'changeCost'));
    ?>
    </div>
    <br>
    時間を選びます<br>
    <select id ="year">
        <?php
        for($i=$current_year;$i>$current_year-50;$i--)
        {
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
        ?>
    </select>
    年
    <select id="month">
        <?php
        for($i=1;$i<=12;$i++)
        {
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
        ?>
    </select>
    月<br>
    <input type="button" id="pay" value="請求データ表示" style="width: 140px;"/>
</div>

<div id="data">    
</div>

<script type="text/javascript">
    $(document).ready(function(){
	$('#pay').click(function(){
			$('#data').html("");
                        var url = '<?php echo $this->Html->url(array('controller' => 'sys_managers','action' => 'pay'));?>' + '/'+ $("#year").val()+ '/'+ $("#month").val();
			$.ajax({
				url : url,
                                cache : false,
				success : function(data){
					$('#data').html(data);
				}
			});
		});
    });
</script>