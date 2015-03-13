<?php
App::uses ( 'AppController', 'Controller' );
class TestMakersController extends AppController {
	var $uses = array ('User', 'Question', 'Testee', 'Answer' );

	public function index() {
		if (isset ( $this->request->query ['status'] ) && ($this->request->query ['status'] != '')) {
			$conditions = array ('user_id' => $this->Session->read ( 'user_id' ), 'status' => $this->request->query ['status'] );
		} else {
			$conditions = array ('user_id' => $this->Session->read ( 'user_id' ) );
		}

		$this->paginate = array ('conditions' => $conditions, 'limit' => 10, 'order' => array ('question_id' => 'desc' ) );
		$questions = $this->paginate ( 'Question' );
		if ($questions == null) {
			$this->Session->setFlash ( 'テストが見つかりません。' );
		}
		$this->set ( 'questions', $questions );
		if ($this->Auth->user ( 'del_flg' ) == 1) {
			$this->render ( 'only_view' );
		}
	}

	public function add() {
		if ($this->request->is ( 'post' )) {
			date_default_timezone_set('Asia/Bangkok');
			$now = getdate();
			$user_id = $this->Session->read ( 'user_id' );
			$data = $this->request->data ['Question'] ['file'];
			if (isset ( $data ['error'] ) && $data ['error'] == 0) {
				$file_path = 'test/' . $user_id . '/' . $data ['name'];
				$files = $this->Question->find ( 'all', array ('conditions' => array ('user_id' => $user_id ), 'fields' => array ('path' ) ) );
				foreach ( $files as $file ) {
					if ($file_path == $file ['Question'] ['path']) {
						$this->Session->setFlash ( 'ファイル名が存在していました。' );
						$this->redirect ( array ('action' => 'add' ) );
					}
				}
				if (move_uploaded_file ( $data ['tmp_name'], $file_path )) {
					$csv_mimetypes = array ('text/csv', 'application/csv', 'text/comma-separated-values', 'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel' );
					if (! in_array ( $data ['type'], $csv_mimetypes )) {
						unlink ( $file_path );
						$this->Session->setFlash ( 'ファイルはcsv形式しなければなりません。' );
					} else {
						$this->Question->create ();
						$test = Common::readTestCSVFile ( $file_path ,null, $now);
						if (! is_array ( $test )) {
							unlink ( $file_path );
							$this->Session->setFlash ( 'ファイルの構造は間違います:' . $test );

						} else {
							$test_start_time = Common::readTestCSVFile ( $file_path, 'test_start_time' );
							//$test_end_time = Common::readTestCSVFile ( $file_path, 'test_end_time' );
							if(isset($test['test']['EndDateTime']))
							{
								$endDateTime = $test['test']['EndDateTime'];
								$test_end_time = mktime(
										$endDateTime['h'],
										$endDateTime['mi'],
										$endDateTime['s'],
										$endDateTime['m'],
										$endDateTime['d'],
										$endDateTime['y']
								);
							}
							if(isset($test['test']['TestTime']))
							{
								$endDateTime =$this->convertEnDateTime($test['test']['StartDateTime'],$test['test']['TestTime']);
								$test_end_time = mktime(
										$endDateTime['h'],
										$endDateTime['mi'],
										$endDateTime['s'],
										$endDateTime['m'],
										$endDateTime['d'],
										$endDateTime['y']
								);
							}
							$question = array ('user_id' => $user_id, 'path' => $file_path, 'test_link' => 'random link here', 'start_date' => date ( 'Y-m-d H:i:s', $test_start_time ), 'end_date' => date ( 'Y-m-d H:i:s', $test_end_time ) );
							$this->Question->save ( $question );
							$this->Question->saveField ( 'test_link', $_SERVER ['SERVER_NAME'] . Router::url ( array ('controller' => 'users', 'action' => 'login', 'test', $this->Question->id ) ) );
							foreach ( $test ['test'] ['Testees'] as $testee ) {
								$this->Testee->create ();
								$testee ['test_id'] = $this->Question->id;
								$testee ['user_id'] = $user_id;
								$testee ['username'] = $testee ['id'];
								$testee ['password'] = AuthComponent::password ( $testee ['password'] );
								$testee ['test_time'] = date ( 'Y-m-d H:i:s', $test_start_time );
								unset ( $testee ['id'] );
								$this->Testee->save ( $testee );
							}
							$this->Session->setFlash ( 'アップロードが成功しました。' );
							$this->redirect ( array ('action' => 'view', $this->Question->id ) );
						}
					}
				}
					
			} else {
				$this->Session->setFlash ( 'アップロードが失敗しました。' );
			}
		}
	}

	public function view($id = null) {
		if ($id != null) {
			$conditions = array ('question_id' => $id, 'user_id' => $this->Session->read ( 'user_id' ) );
			$question = $this->Question->find ( 'first', array ('conditions' => $conditions ) );
			if (count ( $question ) == 0) {
				$this->Session->setFlash ( 'テストのIDが存在しません。' );
				$this->redirect ( array ('action' => 'index' ) );
			}
			$this->set ( compact ( 'question' ) );
		} else {
			$this->redirect ( array ('action' => 'index' ) );
		}
	}

	public function simulation($id = null) {
		if ($id != null) {
			$conditions = array ('question_id' => $id, 'user_id' => $this->Session->read ( 'user_id' ) );
			$question = $this->Question->find ( 'first', array ('conditions' => $conditions ) );
			if (count ( $question ) == 0) {
				$this->Session->setFlash ( 'テストのIDが存在しません。' );
				$this->redirect ( array ('action' => 'index' ) );
			}
			$test_data = Common::readTestCSVFile ( $question ['Question'] ['path'] );
			$this->Session->write ( 'test_data', $test_data );
			$this->set ( 'test_data', $test_data );
			$this->set ( 'test_id', $id );
		} else {
			$this->redirect ( array ('action' => 'index' ) );
		}
	}

	public function delete($id = null) {
		if ($id == null) {
			$this->redirect ( array ('action' => 'index' ) );
		}
		$conditions = array ('question_id' => $id, 'user_id' => $this->Session->read ( 'user_id' ), 'status' => 0 );
		$question = $this->Question->find ( 'first', array ('conditions' => $conditions ) );
		if (count ( $question ) != 0) {
			$this->Question->id = $id;
			$this->Question->delete ();
			$this->Testee->deleteAll ( array ('test_id' => $id ), false );
			unlink ( $question ['Question'] ['path'] );
		} else {
			$this->Session->setFlash('そのテストが削除できない。');
			$this->redirect(array('action' => 'index'));
		}
		$this->redirect ( array ('action' => 'index' ) );
	}
	public function statistic($id=null) {

		//$this->autoRender=false;
		$arr = array ('0-10' => 0, '10-20' => 0, '20-30' => 0, '30-40' => 0, '40-50' => 0, '50-60' => 0, '60-70' => 0, '70-80' => 0, '80-90' => 0, '90-100' => 0, '>100' => 0);
		$user = $this->Question->find('first', array('conditions' => array('question_id' => $id, 'status' => 1 )));
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
			//Debugger::dump($data);
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
				$questions[$i]['score'][] = $data[1][$i-1]['score'][0];
				$questions[$i]['do'][] = ($do == 1) ? 1 : 0;
			}
			Debugger::dump($questions);
			array_push ( $score, $score_ );
			if (0 < $data [2] && $data [2] <= 10)
				$arr ['0-10'] ++;
			else if (10 < $data [2] && $data [2] <=20)
				$arr ['10-20'] ++;
			else if (20 < $data [2] && $data [2] <=30)
				$arr ['20-30'] ++;
			else if (30 < $data [2] && $data [2] <=40)
				$arr ['30-40'] ++;
			else if (40 < $data [2] && $data [2] <= 50)
				$arr ['40-50'] ++;
			else if (50 < $data [2] && $data [2] <=60)
				$arr ['50-60'] ++;
			else if (60 < $data [2] && $data [2] <= 70)
				$arr ['60-70'] ++;
			else if (70 < $data [2] && $data [2] <= 80)
				$arr ['70-80'] ++;
			else if (80 < $data [2] && $data [2] <= 90)
				$arr ['80-90'] ++;
			else if (90 < $data [2] && $data [2] <= 100)
				$arr ['90-100'] ++;
			else if (100 < $data [2])
				$arr ['>100'] ++;
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
		$this->set('scores', $score);
		$this->set ( 'data', $m );
		$this->set ( 'questions', $questions );
	}

	public function listTest() {
		//$user = $this->Session->read ( 'user_id' );
		$user = 8;
		$idTests = $this->Question->find ( 'all', array ('fields' => array ('question_id', 'path' ), 'conditions' => array ('user_id' => $user ) ) );
		echo '<pre>';
		print_r ( $idTests );
		echo '</data>';

	}
	function convertEnDateTime($starTime,$testime)
	{
		$endDateTime['y'] = $starTime['y'];
		$endDateTime['m']= $starTime['m'];
		$endDateTime['d']= $starTime['d'];
		if($testime['unit']=='h')
		{
			$endDateTime['h'] = $starTime['h']+$testime['value'];
			$endDateTime['mi']= $starTime['mi'];
			$endDateTime['s']= $starTime['s'];
		}
		else if($testime['unit']=="m")
		{
			$endDateTime['s'] = $starTime['s'];
			$tmp = intval(($starTime['mi']+$testime['value'])/60);
			$endDateTime['h'] = $starTime['h']+$tmp;
			$endDateTime['mi']= ($starTime['mi']+$testime['value'])-60*$tmp;
		}
		else if($testime['unit']=="s")
		{
			$endDateTime['h'] = $starTime['h'];
			$tmp = intval(($starTime['s']+$testime['value'])/60);
			$endDateTime['mi'] = $starTime['mi']+$tmp;
			$endDateTime['s']= ($starTime['s']+$testime['value'])-60*$tmp;
		}
		return  $endDateTime;
	}
	public function get_answer($test_id = null) {
		if($test_id!= null)
		{
			$option = array(
					'conditions'=>array('question_id'=>$test_id,)
			);
			$answer_list = $this->Answer->find('all',$option);
			if($answer_list == null) {
				$this->Session->setFlash('テストが見つかりません。');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set(compact('answer_list'));
			}
		}
		else {
			$this->redirect(array('action' => 'index'));
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
// 		Debugger::dump($answer_data);
		$this->set('answer_data',$answer_data);
		$this->set('test_data',$test_data);
		$this->set('answer_id',$answer_id);
	}
	public function result($answer_id)
	{
		date_default_timezone_set('Asia/Bangkok');
		$now = getdate();
		$markedata = $this->request->data;
// 		echo '<pre>';
// 		print_r ($markedata);
// 		echo '</pre>';
		$tmp = $this->Answer->find('first',array(
				'fields'=>array('path'),
				'conditions'=>array('answer_id'=>$answer_id)));
		$answer_data = Common::readAnswerSheetCSVFile ($tmp['Answer']['path']);
		foreach (array_keys($markedata) as $data) {
			$data_index = $data - 1;
			$old_score = $answer_data[1][$data_index]['score'][0];
			$new_score = 0;
			$i = 1;
			while (isset($markedata[$data][$i])) {
				$new_score += $markedata[$data][$i]['score'];
				$i ++;
			}
			$comment = $markedata[$data]['comment'];
			$answer_data[1][$data_index]['score'] = array ($new_score, $answer_data[1][$data_index]['score'][1]);
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
				$i_index = 'WR' . $i;
				while (isset($answer[$i_index])) {
					$scorejw = $answer[$i_index][1];
					if (isset($markedata[$answer['number']])) {
						$scorejw = $markedata[$answer['number']][$i]['score'];
					}
					$tmp_body_content[] = array ("QW", $answer['number'], $i_index, $answer[$i_index][0], $scorejw);
					$i ++;
					$i_index = 'WR' . $i;
				}
				
// 							echo '<pre>';
// 							print_r ($answer);
// 							echo '</pre>';
			}
			$tmp_body_content[] = array (($answer['type'] == 'QW') ? "QW" : "QS", $answer['number'], "SC", $answer['score'][0], $answer['score'][1]);
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
		$this->redirect(array('action'=>'index'));
	}
}