<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
*/
class TestManagesController extends AppController {
	public $name = 'TestManages';
	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow();
		$this->Auth->allow();
		//$this->get_test();
	}
	function get_test($id = null) {
                $error = "";
                $test['test'] = 'add';
                echo isset($test['test1']);
		$test_data = Common::readTestCSVFile("test/test1.csv");
		foreach ($test_data['test']['Testees'] as $testee) {
			//$this->Testee->create();
			$testee['test_id'] = $this->Question->id;
			$testee['user_id'] = $user_id;
			$testee['username'] = $testee['id'];
			unset($testee['id']);
			Debugger::dump($testee);
		}
		
		//$test_data['test']['EndDateTime'] = $this->convertEnDateTime($test_data['test']['StartDateTime'], $test_data['test']['TestTime']);
		//Debugger::dump();
				//echo array_key_exists('test', $test_data);
				//echo is_array($test_data);
				echo isset($test_data['test']['TestEndTime']);
                if(!is_array($test_data)) 
                {
                    echo 'loiroi';
                }
//		Common::writeAnswerSheetCSVFile('duc', null);
//		$answers = Common::readAnswerSheetCSVFile('duc');
		$this->set('test_data', $test_data);
		//$this->set('answers', $answers);
		$this->Session->write('test_data',$test_data);
		//$this->Session->write('quetsion_list',$test_data);
	}
	public function test()
	{
		// 		$test_data = Common::readTestCSVFile("test/6/test.csv");
		date_default_timezone_set('Asia/Bangkok');
		$now = getdate();
		$test_data = Common::readTestCSVFile("test1.csv");
		$this->Session->write('test_data',$test_data);
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
		$testtime = ($endDateTime['h']-$now['hours'])*3600+($endDateTime['mi']-$now['minutes'])*60+($endDateTime['s']-$now['seconds']);
		$this->set('testtime',$testtime);
	}
	public function result()
	{
		// package param data
		$question_sheet = $this->Session->read ("test_data");
		$result_sheet = $this->request->data;
		$test_id = "testid_001";
		$testee = array ("Testee", "name of testee", "id of testee");
		$header = array ();
		$body = array ();
		$totalScore = 0;
		// header
		$header['testid'] = array ("TestID", $test_id);
		$header['submittime'] = array ("SubmitTime", "2013", "03", "12", "14", "46", "50");
		$header['testee'] = $testee;
		// body and total score
		$question_sheet = $question_sheet['test']['question'];
		// 		if (isset($result_sheet['question'])) {
		$result_sheet = $result_sheet['question'];
		// 		} else {
			
		// 		}
		echo '<pre>';
		print_r ($result_sheet);
		echo '</pre>';
		echo '<pre>';
		print_r ($question_sheet);
		echo '</pre>';
		// 		print_r ($question_sheet);
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
				for ($j = 0; $j < count ($result_data_result); $j ++) {
					$result_answer_list[] = $result_data_result[$j];
					if ($type == 'QW') {
						$tmp_body_content[$j] = array ("QW", $i, "WR".($j+1), $result_data_result[$j]);
					} else
						$tmp_body_content[$j] = array ("QS", $i, $result_data_result[$j]);
				}
				// calculate score here
				$answer_time = $result_data['time'];
				// convert time1, time2 to s
				$question_time = array ('type' => "TRI", 'time1' => "5", 'time2' => "10");
				if (isset($question_data['LM'])) {
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
					$question_time['time1'] = 0;
				}
				// compare time firstly
				$percent_score = 0;
				if ($question_time['type'] == 'TRI') { // TRI
					if ($question_time['time1'] > $answer_time) {
						$percent_score = 1.0 - $answer_time / $question_time['time1'];
					}
				} else if ($question_time['type'] == 'REC') { // REC
					if ($question_time['time1'] > $answer_time) {
						$percent_score = 1.0;
					}
				} else { // TRAP
					if ($question_time['time1'] >= $answer_time) {
						$percent_score = 1.0;
					} else if ($question_time['time2'] > $answer_time) {
						$percent_score = 1.0 - $answer_time / $question_time['time2'];
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
								if (count ($result_answer_list) == 1) {
									if ($result_answer_list[0] != $righ_answer_list['list_right_answer'][0]) {
										$score = 0;
									} else {
										break;
									}
								} else {
									$score = 0;
								}
							} else if ($righ_answer_list['type'] == 'KSO') {
								if (count ($result_answer_list) <= count ($righ_answer_list['list_right_answer'])) {
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
								if (count ($result_answer_list) == count ($righ_answer_list['list_right_answer'])) {
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
						if (isset($question_data['ANC'])) {
							
						}
						foreach (array_keys($question_data['list_score']) as $right_group) {
							$righ_answer_list = $question_data['right_answer'][$right_group];
							$score = $question_data['list_score'][$right_group];
							// compare answer list with right list
							if ($righ_answer_list['type'] == 'KWA' || $righ_answer_list['type'] == 'KWP') {
								if (count ($result_answer_list) == 1) {
									$istrue = ($righ_answer_list['type'] == 'KWA') ?
									($result_answer_list[0] == $righ_answer_list['list_right_answer'][0]) :
									strstr ($righ_answer_list['list_right_answer'][0], $result_answer_list[0]);
									if (!$istrue) {
										$score = 0;
									} else {
										break;
									}
								} else {
									$score = 0;
								}
							} else if ($righ_answer_list['type'] == 'KWAA' || $righ_answer_list['type'] == 'KWPA') {
								if (count ($result_answer_list) == count ($righ_answer_list['list_right_answer'])) {
									foreach ($result_answer_list as $answer_select) {
										if ($righ_answer_list['type'] == 'KWAA') {
											if (!in_array ($answer_select, $righ_answer_list['list_right_answer'])) {
												$score = 0;
												break;
											}
										} else {
											foreach ($righ_answer_list['list_right_answer'] as $field) {
												if (!strstr ($field, $answer_select)) {
													$score = 0;
													break;
												}
											}
											if ($score == 0) {
												break;
											}
										}
									}
									if ($score != 0) {
										break;
									}
								} else {
									$score = 0;
								}
							} else if ($righ_answer_list['type'] == 'KWAO' || $righ_answer_list['type'] == 'KWPO') {
								if (count ($result_answer_list) <= count ($righ_answer_list['list_right_answer'])) {
									foreach ($result_answer_list as $answer_select) {
										if ($righ_answer_list['type'] == 'KWAO') {
											if (!in_array ($answer_select, $righ_answer_list['list_right_answer'])) {
												$score = 0;
												break;
											}
										} else {
											foreach ($righ_answer_list['list_right_answer'] as $field) {
												if (!strstr ($field, $answer_select)) {
													$score = 0;
													break;
												}
											}
											if ($score == 0) {
												break;
											}
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
					}
					$score = $score * $percent_score;
				} else {
					$score = 0;
				}

			} else {
				$score = 0;
			}
				
			// continue writing
			$tmp_body_content[] = array (($type == 'QW') ? "QW" : "QS", $i, "SC", $score);
			if ($type == 'QW') {
				$tmp_body_content[] = array ("QW", $i, "INS", "CHK", "neet mark");
			}

			$body[] = $tmp_body_content;
			$totalScore += $score;
		}

		$totalScore = array ("TotalSC", $totalScore);

		$param_data = array ($header, $body, $totalScore);
		echo '<pre>';
		print_r($param_data);
		echo '</pre>';


		// call write anwser sheet file
		Common::writeAnswerSheetCSVFile ("MathTest0001_20080849_20130314080500", $param_data);
		// test read file
		$read_data = Common::readAnswerSheetCSVFile ("MathTest0001_20080849_20130314080500");
		$header = $read_data[0];
		$body = $read_data[1];
		$totalScore = $read_data[2];
		echo '<pre>';
		print_r ($header); echo '</pre>';echo '<pre>';
		print_r ($body); echo '<pre>';echo '</pre>';
		print_r ($totalScore); echo '</pre>';
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

