<?php
App::uses ( 'AppController', 'Controller' );
class TestMarkersController extends AppController {
	var $uses = array('User', 'Question','Answer','OrgManager');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function index()
	{
		$user_id=$this->Session->read('user_id');
		$org_id = $this->OrgManager->find('first',array(
				'fields'=>array('org_manager_id'),
				'conditions'=>array('user_id'=>$user_id)
		));
		$org_manager = $this->User->find('first',array(
				'conditions'=>array('id'=>$org_id['OrgManager']['org_manager_id'])
		));
		$this->set('orgFirstName',$org_manager['User']['firstname']);
		$this->set('orgLastName',$org_manager['User']['lastname']);
		$option = array(
				'conditions'=>array(
						'question_id !='=>0,
						'org_manager_id'=>$org_id['OrgManager']['org_manager_id']),
				'fields'=>array('question_id'),
				'group'=>'question_id');
		$test_list = $this->Answer->find('all',$option);
		$this->set('test_list',$test_list);
	}

	public function getAnswer($test_id)
	{
		$this->autoRender=false;
		$user_id=$this->Session->read('user_id');
		$flag = $this->User->find('first',array(
				'fields'=>array('del_flg'),
				'conditions'=>array('id'=>$user_id)
		));
		if($test_id!= null)
		{
			$option = array(
					'conditions'=>array
					('question_id'=>$test_id)
			);
			$answer_list = $this->Answer->find('all',$option);
			echo '<table><tr><th>番号</th><th>テストid</th><th>回答者</th><th>時間</th><th>採点した</th><th></th><th></th><tr>';
			$i=0;
			foreach ($answer_list as $answer)
			{
				$i++;
				echo '<tr>';
				echo '<td>'.$i.'</td>';
				echo '<td>'.$answer['Answer']['question_id'].'</td>';
				echo '<td>'.$answer['Answer']['tester'].'</td>';
				echo '<td>'.$answer['Answer']['upload_date'].'</td>';
				echo '<td>';
				if($answer['Answer']['is_markered']==0)
				{
					echo 'まだ採点しない';
				}
				else echo '採点した';
				echo '</td>';
				if($flag['User']['del_flg'] == 0)
				{
					echo '<td>';
					if ($answer['Answer']['is_markered'] != 2) {
						echo '<a href="test_markers/mark/'.$answer['Answer']['answer_id'].'">採点</a>';
					} else {
						echo '採点';
					}
					echo '</td>';
				}
				echo '<tr>';
			}
			echo '</table>';
			$test = $this->Question->findByQuestionId($test_id);
			//if($test['Question']['status'] == 1)echo $this->Html->link('統計', array('action' => 'statistic', $answer['Answer']['question_id']));
			if(isset ($test['Question']['status']) && ($test['Question']['status'] == 1)) echo '<a href="test_markers/statistic/'.$answer['Answer']['question_id'].'"class='.'"button"'.'align='.'"right">統計</a>';
		}
	}

	public function mark($answer_id=null)
	{
		$tmp = $this->Answer->find('first',array(
				'fields'=>array('path'),
				'conditions'=>array('answer_id'=>$answer_id)));
		$answer_data = Common::readAnswerSheetCSVFile ($tmp['Answer']['path']);
		$testid = $answer_data[0]['testid'];
		$tmp = $this->Question->find('first',array(
				'fields'=>array('path'),
				'conditions'=>array('question_id'=>$testid)));
		$test_data = Common::readTestCSVFile($tmp['Question']['path']);

		$this->set('answer_data',$answer_data);
		$this->set('test_data',$test_data);
		$this->set('answer_id',$answer_id);
	}
	public function result($answer_id)
	{
		date_default_timezone_set('Asia/Bangkok');
		$now = getdate();
		$markedata = $this->request->data;
		$tmp = $this->Answer->find('first',array(
				'fields'=>array('path'),
				'conditions'=>array('answer_id'=>$answer_id)));
		$answer_data = Common::readAnswerSheetCSVFile ($tmp['Answer']['path']);
		foreach (array_keys($markedata) as $data) {
			$data_index = $data - 1;
			$old_score = $answer_data[1][$data_index]['score'];
			$new_score = 0;
			$i = 1;
			while (isset($markedata[$data][$i])) {
				$new_score += $markedata[$data][$i]['score'];
				$i ++;
			}
			$comment = $markedata[$data]['comment'];
			$answer_data[1][$data_index]['score'] = $new_score;
			$answer_data[1][$data_index]['INS'] = $comment;
			$answer_data[2] += ($new_score - $old_score);
		}
		// re-write
		// header
		$header['testid'] = array ("TestID", $answer_data[0]['testid']);
		$header['submittime'] = array ("SubmitTime",  $answer_data[0]['submittime'][0], $answer_data[0]['submittime'][1], $answer_data[0]['submittime'][2], $answer_data[0]['submittime'][3], $answer_data[0]['submittime'][4], $answer_data[0]['submittime'][5]);
		$header['testee'] = array ("Testee", $answer_data[0]['testee']['name'], $answer_data[0]['testee']['id']);
		// total score
		$totalScore = array ("TotalSC", $answer_data[2]);
		// body
		$body = array ();
		foreach ($answer_data[1] as $answer) {
			$tmp_body_content = array ();

			if ($answer['type'] == 'QS') {
				$i = 0;
				while (isset($answer[$i])) {
					$tmp_body_content[] = array ("QS", $answer['number'], $answer[$i]);
					$i ++;
				}
			} else {
				$i = 1;
				while (isset($answer['WR'.$i])) {
					$tmp_body_content[] = array ("QW", $answer['number'], 'WR'.$i, $answer['WR'.$i][0], $markedata[$answer['number']][$i]['score']);
					$i ++;
				}
			}
			$tmp_body_content[] = array (($answer['type'] == 'QW') ? "QW" : "QS", $answer['number'], "SC", $answer['score']);
			if ($answer['type'] == 'QW') {
				$tmp_body_content[] = array ("QW", $answer['number'], "INS", "CHK", $answer['INS']);
			}
			$body[] = $tmp_body_content;
		}

		$param_data = array ($header, $body, $totalScore);

		// call write anwser sheet file
		Common::writeAnswerSheetCSVFile ($tmp['Answer']['path'], $param_data);
		$data = $this->Answer->findByAnswerId($answer_id);
		$data['Answer']['is_markered']=1;
		$data['Answer']['marked_date']=date('Y-m-d H:i:s',$now[0]);
		$this->Answer->save($data);
		$this->Session->setFlash ('採点できました。');
		$this->redirect(array('controller' => 'test_markers', 'action'=>'index'));
	}
	// thống kê
	public function statistic($id=null) {
		//$this->autoRender=false;
		$arr = array ('0-10' => 0, '10-20' => 0, '20-30' => 0, '30-40' => 0, '40-50' => 0, '50-60' => 0, '60-70' => 0, '70-80' => 0, '80-90' => 0, '90-100' => 0 );
		$user = $this->Question->find('first', array('conditions' => array('question_id' => $id)));
		if($user != null) $path = $this->Answer->find ( 'all', array ('fields' => array ('path' ), 'conditions' => array ('question_id' => $id ) ) );
		else {
			$this->Session->setFlash('そのテストが統計できない。');
			$this->redirect(array('action' => 'index'));
		}
		if(!isset($path) || $path == null) {
			$this->Session->setFlash('テストが違います。');
			$this->redirect(array('action' => 'index'));
		}
		$testname = Common::readTestCSVFile($user['Question']['path'], 'test_name');
		$this->set("testname", $testname);
		$score = array ();
		$questions = array();
		foreach ( $path as $row ) {
			$path = $row ['Answer'] ['path'];
			$data = Common::readAnswerSheetCSVFile ( $path );
			$count = count($data[1]);
			$score_ = array ('id' => $data ['0'] ['testee'] ['id'], 'score' => $data ['2'] );
			for($i = 1; $i <= $count; $i++) {
				$do = 0;
				if(isset($data[1][$i-1][0])) {
					$do = 1;
				}
				else {
					$j = 1;
					while(isset($data[1][$i-1]['WR'.$j])) {
						if($data[1][$i-1]['WR'.$j] != '') {
							$do = 1;
							break;
						}
						$j++;
					}
				}
				$questions[$i]['score'][] = $data[1][$i-1]['score'];
				$questions[$i]['do'][] = ($do == 1) ? 1 : 0;
			}
			array_push ( $score, $score_ );
			if (0 < $data [2] && $data [2] <= 10)
				$arr ['0-10'] ++;
			else if (10 < $data [2] && $data [2] <= 20)
				$arr ['10-20'] ++;
			else if (20 < $data [2] && $data [2] <= 30)
				$arr ['20-30'] ++;
			else if (30 < $data [2] && $data [2] <= 40)
				$arr ['30-40'] ++;
			else if (40 < $data [2] && $data [2] <= 50)
				$arr ['40-50'] ++;
			else if (50 < $data [2] && $data [2] <= 60)
				$arr ['50-60'] ++;
			else if (60 < $data [2] && $data [2] <= 70)
				$arr ['60-70'] ++;
			else if (70 < $data [2] && $data [2] <= 80)
				$arr ['70-80'] ++;
			else if (80 < $data [2] && $data [2] <= 90)
				$arr ['80-90'] ++;
			else if (90 < $data [2] && $data [2] <= 100)
				$arr ['90-100'] ++;

		}
		$sc = array ();
		foreach ( $score as $key => $row ) {
			$sc [$row['id']] = $row ['score'];
		}
		array_multisort ( $sc, SORT_DESC, $score );
		$this->set ( 'score', $sc );
		$a = array ('id' => 'score', 'label' => '点', 'type' => 'string' );
		$b = array ('id' => 'students', 'label' => '人数', 'type' => 'number' );
		$m = array ($a, $b );
		$h ['cols'] = $m;
		$g = array ();

		foreach ( $arr as $x => $value ) {
			$d = array ('v' => $x );
			$e = array ('v' => $value );
			$t = array ('f' => $x . 'ten' );
			$e1 = array ($d, $e, $t );
			$f ['c'] = $e1;
			array_push ( $g, $f );
		}
		$h ['rows'] = $g;
		$m = json_encode ( $h );
		$this->set ( 'data', $m );
		$this->set ( 'questions', $questions );
	}
}