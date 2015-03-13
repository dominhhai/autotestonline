
<?php
   echo $this->Form->create('payForm',array(
        'url'=>array('controller'=>'sys_managers','action'=>'process')));
?>
<div>
    システム管理者：
    <?php echo $user['name'].'<br>'?>
    本請求データ時間：<?php echo $pay_year;?>年<?php echo $pay_month;?>月<br><br>
    作成時間：<?php echo date('Y-m-d H:i:s',$now[0])?><br><br>
     
    <input type="hidden" name="maker[id]" value="<?php echo $user['id']?>">
    <input type="hidden" name="maker[name]" value="<?php echo $user['name']?>">
    
    <input type="hidden" name="date_cal[y]" value="<?php echo $pay_year;?>">
    <input type="hidden" name="date_cal[m]" value="<?php if ($pay_month > 9) { echo $pay_month; } else { echo '0' . $pay_month; }?>">
    
    <input type="hidden" name="date_cre[y]" value="<?php echo $now['year']?>">
    <input type="hidden" name="date_cre[m]" value="<?php echo ($now['mon'] > 9 ? $now['mon'] : ('0' . $now['mon']))?>">
    <input type="hidden" name="date_cre[d]" value="<?php echo ($now['mday'] > 9 ? $now['mday'] : ('0' . $now['mday']))?>">
    <input type="hidden" name="date_cre[hh]" value="<?php echo ($now['hours'] > 9 ? $now['hours'] : ('0' . $now['mon']))?>">
    <input type="hidden" name="date_cre[mm]" value="<?php echo ($now['minutes'] > 9 ? $now['minutes'] : ('0' . $now['mon']))?>">
    <input type="hidden" name="date_cre[ss]" value="<?php echo ($now['seconds'] > 9 ? $now['seconds'] : ('0' . $now['seconds']))?>">
    
</div>

<div>
	<table border="1">
	<tr>
		<th>番号</th>
		<th>団体管理者のID</th>
		<th>団体管理者の名前</th>
		<th>団体管理者の住所</th>
		<th>団体管理者の電話番号</th>
		<th>テスト数</th>
		<th>合計</th>
	</tr>
    <?php 
        $i=0;
        foreach ($org_list as $org)
        {
        	echo '<tr>';
            $i++;
            $phone1 = $org['phone'];
            $phone = substr ($phone1, 0, 6).'-'.substr ($phone1, 6, 3).'-'.substr ($phone1, 9);
            //echo '<div>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$org['id'].'</td>';
            echo '<td>'.$org['name'].'</td>';
            echo '<td>'.$org['address'].'</td>';
            echo '<td>'.$phone.'</td>';
            echo '<td>'.$org['testTotal'].'</td>';
            echo '<td>'.$org['costTotal'].'</td>';
            
            //echo '('.$i.') 団体名：'.$org['name'].'<br>';
            //echo '電話番号：'.$phone.'<br>';
            //echo '住所：'.$org['address'].'<br>';
            //echo 'テスト数：'.$org['testTotal'].'<br>';
            //echo '合計：'.($test_cost * $org['testTotal']).'<br><br>';
            
            echo '</tr>';
    
            echo '<input type="hidden" name = "list_cal['.$i.'][0]" value ="'.$org['id'].'">';
            echo '<input type="hidden" name = "list_cal['.$i.'][1]" value ="'.$org['name'].'">';
            echo '<input type="hidden" name = "list_cal['.$i.'][2]" value ="'.$org['costTotal'].'">';
            echo '<input type="hidden" name = "list_cal['.$i.'][3]" value ="'.$org['address'].'">';
            echo '<input type="hidden" name = "list_cal['.$i.'][4]" value ="'.$phone.'">';
        }
    ?>
    </table>
</div>
<input type="submit" value="データ輸出"/>
</form>