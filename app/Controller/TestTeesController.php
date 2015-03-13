<?php
App::uses('AppController', 'Controller');

class TestTeesController extends AppController {
	public $uses = array('Question','Answer');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
		if(!$this->Session->read('logged_in') || !$this->Session->read('testtee')) {
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
	}
	public function index()
	{
		date_default_timezone_set('Asia/Bangkok');
		$now = getdate();
		$testid = $this->Session->read('test_id');
		$testee = $this->Auth->user('username');
		$answer = $this->Answer->find('first', array('conditions' => array('question_id' => $testid, 'tester' => $testee)));
		if($answer != null) $this->set(compact('answer'));
		$tmp = $this->Question->find('first',array(
				'fields'=>array('path'),
				'conditions'=>array('question_id'=>$testid)));

		$test_data = Common::readTestCSVFile($tmp['Question']['path']);
		$this->set('test_data',$test_data);
		if(isset($test_data['test']['StartDateTime']))
		{
			$start_time = mktime(
					$test_data['test']['StartDateTime']['h'],
					$test_data['test']['StartDateTime']['mi'],
					$test_data['test']['StartDateTime']['s'],
					$test_data['test']['StartDateTime']['m'],
					$test_data['test']['StartDateTime']['d'],
					$test_data['test']['StartDateTime']['y']
			);
			$this->set('start_time',$start_time);
		}
		if(isset($test_data['test']['EndDateTime']))
		{
			$endDateTime = $test_data['test']['EndDateTime'];
			$end_time = mktime(
					$endDateTime['h'],
					$endDateTime['mi'],
					$endDateTime['s'],
					$endDateTime['m'],
					$endDateTime['d'],
					$endDateTime['y']
			);
			$this->set('end_time',$end_time);
		}
		if(isset($test_data['test']['TestTime']))
		{
			$endDateTime =$this->convertEnDateTime($test_data['test']['StartDateTime'],$test_data['test']['TestTime']);
			$end_time = mktime(
					$endDateTime['h'],
					$endDateTime['mi'],
					$endDateTime['s'],
					$endDateTime['m'],
					$endDateTime['d'],
					$endDateTime['y']
			);
			$this->set('end_time',$end_time);
		}
	}
	public function test()
	{
		date_default_timezone_set('Asia/Bangkok');
		$now = getdate();
		$testUser = $this->Session->read('testtee');
		$testid = $this->Session->read('test_id');
		//get Test data by test id
		$tmp_question = $this->Question->find('first',array(
				'fields'=>array('path', 'question_id', 'status'),
				'conditions'=>array('question_id'=>$testid)));
		$test_data = Common::readTestCSVFile($tmp_question['Question']['path']);
		$this->set('test_data',$test_data);
		//get current time
		if(isset($test_data['test']['StartDateTime']))
		{
			$start_time = mktime(
					$test_data['test']['StartDateTime']['h'],
					$test_data['test']['StartDateTime']['mi'],
					$test_data['test']['StartDateTime']['s'],
					$test_data['test']['StartDateTime']['m'],
					$test_data['test']['StartDateTime']['d'],
					$test_data['test']['StartDateTime']['y']
			);
		}
		if(isset($test_data['test']['EndDateTime']))
		{
			$endDateTime = $test_data['test']['EndDateTime'];
			$end_time = mktime(
					$endDateTime['h'],
					$endDateTime['mi'],
					$endDateTime['s'],
					$endDateTime['m'],
					$endDateTime['d'],
					$endDateTime['y']
			);
		}
		if(isset($test_data['test']['TestTime']))
		{
			$endDateTime =$this->convertEnDateTime($test_data['test']['StartDateTime'],$test_data['test']['TestTime']);
			$end_time = mktime(
					$endDateTime['h'],
					$endDateTime['mi'],
					$endDateTime['s'],
					$endDateTime['m'],
					$endDateTime['d'],
					$endDateTime['y']
			);
		}
		//if current time < start time or current > end time , don't test .
		if(date("Y-m-d:H:i:s",$now[0])<date("Y-m-d:H:i:s",$start_time))
		{
			$this->Session->write('error','テストはまだ始めない。待ってください。');
			$this->redirect(array('controller'=>'test_tees','action'=>'index'));
		}
		if(isset($end_time))
		{
			if(date("Y-m-d:H:i:s",$now[0])>date("Y-m-d:H:i:s",$end_time))
			{
				//setFlash('テストはもう終わりました。');
				$this->Session->write('error','テストはもう終わりました。');
				$this->redirect(array('controller'=>'test_tees','action'=>'index'));
			}
		}
		$tmp_answer = $this->Answer->find('first',array('conditions'=>array(
				'question_id'=>$testid,
				'tester'=>$testUser['Testee']['username']
		)));
		if(isset($tmp_answer['Answer']))
		{
			$this->Session->write('error','テストはもう完成しました');
			$this->redirect(array('controller'=>'test_tees','action'=>'index'));
		}
		$testtime = ($endDateTime['h']-$now['hours'])*3600+($endDateTime['mi']-$now['minutes'])*60+($endDateTime['s']-$now['seconds']);
		$this->set('testtime',$testtime);
		// update db
		if ($tmp_question['Question']['status'] == 0) {
			$this->Question->id = $tmp_question['Question']['question_id'];
			$this->Question->saveField ('status', 1);
		}
	}
	public function statistic() {
		$testid = $this->Session->read('test_id');
		$testee = $this->Auth->user('username');
		$answer = $this->Answer->find('first', array('conditions' => array('question_id' => $testid, 'tester' => $testee)));
		if($answer != null) {
			$data = Common::readAnswerSheetCSVFile($answer['Answer']['path']);
			$question = $this->Question->findByQuestionId($testid);
			$test = Common::readTestCSVFile($question['Question']['path'], 'test_name');
			$this->set(compact(array('data', 'test')));
		} else {
			$this->redirect(array('action' => 'index'));
		}
	}
	public function result()
	{
		date_default_timezone_set('Asia/Bangkok');
		$testid = $this->Session->read('test_id');
		$testUser = $this->Session->read('testtee');
		$tmp = $this->Question->find('first',array(
				'fields'=>array('path'),
				'conditions'=>array('question_id'=>$testid)));
		$question_sheet = Common::readTestCSVFile($tmp['Question']['path']);
		$result_sheet = $this->request->data;
		$testee = array ("Testee", $testUser['Testee']['name'], $testUser['Testee']['username']);
		$now = getdate();
		$is_markerable = 2;

		// begin cal and save file
		$header = array ();
		$body = array ();
		$totalScore = 0;
		// header
		$header['testid'] = array ("TestID", $testid);
		$header['submittime'] = array ("SubmitTime",$now['year'], $now['mon'], $now['mday'], $now['hours'], $now['minutes'], $now['seconds']);
		$header['testee'] = $testee;
		// body and total score
		$question_sheet = $question_sheet['test']['question'];
		$result_sheet = $result_sheet['question'];
		for ($i = 1; $i <= count ($question_sheet); $i ++) {
			$question_data = $question_sheet['Q('.$i.')'];
			$result_data = $result_sheet['Q('.$i.')'];

			$type = $question_data['type'];
			$score = 0;
			$tmp_body_content = array ();
			$result_data_result = NULL;
			if (isset ($result_data['result'])) {
			 $result_data_result = $result_data['result'];
			}
			if ($result_data_result != NULL) {
				$result_answer_list = array ();
				$number_answer = count ($result_data_result);
				for ($j = 0; $j < $number_answer; $j ++) {
					$result_answer_list[$j] = $result_data_result[$j];
					if ($type == 'QW') {
						$tmp_body_content[$j] = array ("QW", $i, "WR".($j+1), $result_data_result[$j], 0);
					} else {
						$tmp_body_content[$j] = array ("QS", $i, $result_data_result[$j]);
					}
				}
				// calculate score here
				$percent_score = 1.0; // percent decrease score
				$answer_time = $result_data['time']; // time for answer
				if (isset($question_data['LM'])) {
					// convert time1, time2 to s
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
					// compare time firstly

					if ($question_time['type'] == 'TRI') { // TRI
						if ($question_time['time1'] > $answer_time) {
							$percent_score = 1.0 - $answer_time / $question_time['time1'];
						} else {
							$percent_score = 0;
						}
					} else if ($question_time['type'] == 'REC') { // REC
						if ($question_time['time1'] > $answer_time) {
							$percent_score = 1.0;
						} else {
							$percent_score = 0;
						}
					} else { // TRAP
						if ($question_time['time1'] >= $answer_time) {
							$percent_score = 1.0;
						} else if ($question_time['time2'] > $answer_time) {
							$percent_score = 1.0 - $answer_time / $question_time['time2'];
						} else {
							$percent_score = 0;
						}
					}
				}

				if ($percent_score > 0) {
					// select
					if ($type == 'QS') {
						foreach (array_keys($question_data['list_score']) as $right_group) {
							$righ_answer_list = $question_data['right_answer'][$right_group];
							$score = $question_data['list_score'][$right_group];
							// compare result_answer_list and right_answer_list
							if ($righ_answer_list['type'] == 'KS') {
								if ($number_answer == 1) {
									if ($result_answer_list[0] != $righ_answer_list['list_right_answer'][0]) {
										$score = 0;
									} else {
										break;
									}
								} else {
									$score = 0;
								}
							} else if ($righ_answer_list['type'] == 'KSO') {
								if ($number_answer <= count ($righ_answer_list['list_right_answer'])) {
									foreach ($result_answer_list as $answer_select) {
										if (!in_array ($answer_select, $righ_answer_list['list_right_answer'])) {
											$score = 0;
											break;
										}
									}
									if ($score != 0) {
										break;
									}
								} else {
									$score = 0;
								}
							} else if ($righ_answer_list['type'] == 'KSA') {
								if ($number_answer == count ($righ_answer_list['list_right_answer'])) {
									foreach ($result_answer_list as $answer_select) {
										if (!in_array ($answer_select, $righ_answer_list['list_right_answer'])) {
											$score = 0;
											break;
										}
									}
									if ($score != 0) {
										break;
									}
								} else {
									$score = 0;
								}
							} else {
								$score = 0;
							}
						}
					} else {// write
						// check for VINP （手動的に採点する）
						//if (!array_key_exists ("VINP", $question_data['list_score'])) { // 自動採点
						$score = 0;
						$number_question_data_list_score = count ($question_data['list_score']);
						//$checked_wr_index_list = array ();
						foreach (array_keys($question_data['list_score']) as $right_group) {
							if (isset($question_data['right_answer'])) {
								$righ_answer_list = $question_data['right_answer'][$right_group];
								$tmp_score = $question_data['list_score'][$right_group];
								// check ANC
								if (isset($question_data['ANC']) && in_array ($right_group, $question_data['ANC'])) { // in list ANC
									$ismatched = false;
									foreach ($question_data['ANC'] as $anc) { // toi uu bang cach luu lai index da khop AN(19)
										$index = substr ($anc, 3, strlen ($anc) - 4) - 1;
										if ($index >= $number_answer) {
											$index = $number_answer - 1;
										}
										//if (!in_array ($index, $checked_wr_index_list)) {
											if ($this->compareWRwithAN ($result_answer_list[$index], $righ_answer_list)) {
												$ismatched = true;
										//		$checked_wr_index_list[] = $index;
												break;
											}
										//}
									}
									if (!$ismatched) {
										$tmp_score = 0;
									}
								} else { // not in list ANC
									$index = substr ($right_group, 3, strlen ($right_group) - 4) - 1; // index relative AN(i) with WR(i)
									if ($index >= $number_answer) {
										$index = $number_answer - 1;
									}
									if (!$this->compareWRwithAN ($result_answer_list[$index], $righ_answer_list)) {
										$tmp_score = 0;
									}
								}
								// update score for answer
								$tmp_body_content[$index][4] = $tmp_score;
								// cong don diem neu so list diem bang so cau tra loi
								if ($number_answer == $number_question_data_list_score) {
									$score =  $score + $tmp_score;

								} else if ($tmp_score > 0) {
									$score = $tmp_score;
									break;
								}
							}
						}
						//	} else { // 手動的に採点
						//$score = 0;
						if (array_key_exists ("VINP", $question_data['list_score'])) {
							$is_markerable = 0;
						}
						//}
					}
					$score = $score * $percent_score;
				} else {
					$score = 0;
				}

			} else {
				$score = 0;
			}

			// continue writing
			$tmp_body_content[] = array (($type == 'QW') ? "QW" : "QS", $i, "SC", $score, $answer_time);
			if ($type == 'QW') {
				$tmp_body_content[] = array ("QW", $i, "INS", "CHK", "コメント入力");
			}

			$body[] = $tmp_body_content;
			if ($type == 'QW') {
			}
			$totalScore += $score;
		}

		$totalScore = array ("TotalSC", $totalScore);

		$param_data = array ($header, $body, $totalScore);
		$fileName = 'MathTest_'.$testid.'_'.$testUser['Testee']['username'];
		//save test answer in database
		$org_id = $this->Session->read('org_id');
		$cost = intval(file_get_contents('cost/cost.txt'));
		$answer['Answer'] = array(
				'question_id'=>$testid,
				'upload_date'=>date('Y-m-d H:i:s',$now[0]),
				'path'=>$fileName,
				'tester'=>$testUser['Testee']['username'],
				'is_markered'=>$is_markerable,
				'org_manager_id'=>$org_id,
				'cost_per_test'=>$cost
		);
		$this->loadModel('Answer');
		$this->Answer->create();
		$this->Answer->save($answer);
		// call write anwser sheet file
		Common::writeAnswerSheetCSVFile ($fileName, $param_data);

		// Add answer file data into database (answer sheet table)
		$this->set('totalScore',$totalScore[1]);
	}

	function compareWRwithAN ($wr, $righ_answer_list) {
		if ($wr == '') {
			return false;
		}
		// compare answer list with right list
		if ($righ_answer_list['type'] == 'KWA' || $righ_answer_list['type'] == 'KWP') {
			// 			$istrue = $this->compareKeyWithAN ($wr, $righ_answer_list['list_right_answer'][0], ($righ_answer_list['type'] == 'KWA') ? true : false);
			$istrue = (strstr ($wr, $righ_answer_list['list_right_answer'][0]) !== FALSE);
			return $istrue;
		} else if ($righ_answer_list['type'] == 'KWAA' || $righ_answer_list['type'] == 'KWPA') {
			foreach ($righ_answer_list['list_right_answer'] as $right_answer) {
				// 				$istrue = $this->compareKeyWithAN ($wr, $right_answer, ($righ_answer_list['type'] == 'KWAA') ? true : false);
				$istrue = (strstr ($wr, $right_answer) !== FALSE);
				if (!istrue) {
					return false;
				}
			}
			return true;
		} else if ($righ_answer_list['type'] == 'KWAO' || $righ_answer_list['type'] == 'KWPO') {
			foreach ($righ_answer_list['list_right_answer'] as $right_answer) {
				// 				echo '<pre>';
				// 				print_r ('pre-ok: ' . $right_answer);
				// 				echo '</pre>';
				// 				$istrue = $this->compareKeyWithAN ($wr, $right_answer, ($righ_answer_list['type'] == 'KWAO') ? true : false);
				$istrue = (strstr ($wr, $right_answer) !== FALSE);
				// 				echo '<pre>';
				// 				if ($istrue) {
				// 					print_r ('ok++:' . $wr . '; ' . $right_answer);
				// 				} else {
				// 					print_r ('ok--:' . $wr . '; ' . $right_answer);
				// 				}
				// 				echo '</pre>';
				if ($istrue) {
					return true;
				}
			}
			return false;
		} else {
			return false;
		}
	}

	function compareKeyWithAN ($wr, $righ_anwer, $isA) {
		$is_match = false;

		if ($isA) { // co toan bo
			$is_match = (strpos ($wr, $righ_anwer) !== false);
		} else { // co 1 phan trong righ_answer
			$result = $this->get_longest_common_subsequence ($wr, $righ_anwer);
			$is_match = ($result !== "");
		}
		return $is_match;
	}

	function get_longest_common_subsequence($string_1, $string_2)
	{
		$string_1_length = strlen($string_1);
		$string_2_length = strlen($string_2);
		$return          = "";

		if ($string_1_length === 0 || $string_2_length === 0)
		{
			// No similarities
			return $return;
		}

		$longest_common_subsequence = array();

		// Initialize the CSL array to assume there are no similarities
		for ($i = 0; $i < $string_1_length; $i++)
		{
			$longest_common_subsequence[$i] = array();
			for ($j = 0; $j < $string_2_length; $j++)
			{
				$longest_common_subsequence[$i][$j] = 0;
			}
		}

		$largest_size = 0;

		for ($i = 0; $i < $string_1_length; $i++)
		{
			for ($j = 0; $j < $string_2_length; $j++)
			{
				// Check every combination of characters
				if ($string_1[$i] === $string_2[$j])
				{
					// These are the same in both strings
					if ($i === 0 || $j === 0)
					{
						// It's the first character, so it's clearly only 1 character long
						$longest_common_subsequence[$i][$j] = 1;
					}
					else
					{
						// It's one character longer than the string from the previous character
						$longest_common_subsequence[$i][$j] = $longest_common_subsequence[$i - 1][$j - 1] + 1;
					}

					if ($longest_common_subsequence[$i][$j] > $largest_size)
					{
						// Remember this as the largest
						$largest_size = $longest_common_subsequence[$i][$j];
						// Wipe any previous results
						$return       = "";
						// And then fall through to remember this new value
					}

					if ($longest_common_subsequence[$i][$j] === $largest_size)
					{
						// Remember the largest string(s)
						$return = substr($string_1, $i - $largest_size + 1, $largest_size);
					}
				}
				// Else, $CSL should be set to 0, which it was already initialized to
			}
		}

		// Return the list of matches
		return $return;
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
}