<?php 
class Common {
	/**
	 * 回答シートCSVファイルを書くメソッド
	 *
	 * 注意: ファイル名のフォーマットは: 問題シートのID＿回答者のID.csv. 例: MathTest0001_20080849.csv
	 *
	 * param 1: $filename: /path/to/filename (.csv 無し)　ファイルのディレクトリ
	 * param 2: $data のフォマット(ヘッダー,　ボディ, 統合点数)
	 *   - ヘッダー (問題シートのID, アップロード時間, 回答者);
	 *     - 問題シートのID => array ("TestID", 問題シートのID),
	 *     - アップロード時間 => array ("SubmitTime", YYYY, MM, DD, hh, mm, ss),
	 *     - 回答者 => array("Testee", 回答者の名前, 回答者のID),
	 *   - ボディ (問題 1, 問題 2, ..., 問題 n);
	 *     - 選択問題:
	 *       問題 => (
	 *                    array ("QS", "問題順番", "選択１"),
	 *                    array ("QS", "問題順番", "選択２"),
	 *                    .....
	 *                    array ("QS", "問題順番", "選択n"),
	 *                    array ("QS", "問題順番", "SC", 得点),
	 *                    );
	 *     - 記述問題
	 *       問題 => (
	 *                    array ("QW", "問題順番", "WR".第一, 第一の内容,第一の得点),
	 *                    .....
	 *                    array ("QW", "問題順番", "WR".第n, 第nの内容,第nの得点),
	 *                    array ("QS", "問題順番", "SC", 得点),
	 *                    array ("QS", "問題順番", "INS", INS　のID (CHK | CINP), INSの内容),
	 *                    );
	 */
	public function writeAnswerSheetCSVFile ($filename, $data) {
		$header = $data[0];
		$body = $data[1];
		$totalScore = $data[2];

		$file = 'answer_sheet/'.$filename.'.csv';
		$fp = fopen($file, 'w');
		// header
		foreach ($header as $row) {
			fputcsv($fp, $row);
		}
		//body
		foreach ($body as $question) {
			// question
			foreach ($question as $row) {
				fputcsv ($fp, $row);
			}
		}
			
		// score
		fputcsv ($fp, $totalScore);
			
		fclose($fp);
	}


	/**
	 *回答シートCSVファイルを読むメソッド
	 *
	 * param 1: $file name: /path/to/filename (.csv 無し)　ファイルのディレクトリ
	 *
	 * - ヘッダー (問題のID, アップロード時間, 回答者のID);
	 * - ボディ (問題 1, 問題 2, ... 問題 n);
	 *    選択問題
	 *    - 問題 (QS, 問題順番, 選択 1, 選択 2, ..., 選択 n, 得点);
	 *  　記述問題
	 *    - 問題 (QW, 問題順番,　問題 1, 問題 1の記述, ..., 問題 n, 問題 nの記述, 得点, INSのID, INSの内容);
	 * - 統合点数 (テストの得点);
	 *
	 * return array (ヘッダー, ボディ, 統合点数)
	 */

	public function readAnswerSheetCSVFile ($file_path) {
		$header = array ();
		$body = array ();
		$totalScore = array();

		$file = 'answer_sheet/'.$file_path.'.csv';
		$tmp_body_content = array();
		if (($fp = fopen($file, 'r')) == FALSE) {
			return false;
		}
		while (($row = fgetcsv ($fp)) !== FALSE) {
// 			echo '<pre>';
// 			print_r ($row);
// 			echo '</pre>';
			$col = 0;
			$MAX_COL = count ($row);
			$col = Common::getNextData ($row, $col, $MAX_COL);
			if ($col != -1) {
				switch ($row[$col]) {
					// header
					case 'TestID':
						$col = Common::getNextData ($row, ($col + 1), $MAX_COL);
						$header['testid'] = $row[$col];
						break;
					case 'SubmitTime':
						$header['submittime'] = array ($row[$col = Common::getNextData ($row, ($col + 1), $MAX_COL)], // Y
						$row[$col = Common::getNextData ($row, ($col + 1), $MAX_COL)], // M
						$row[$col = Common::getNextData ($row, ($col + 1), $MAX_COL)], // D
						$row[$col = Common::getNextData ($row, ($col + 1), $MAX_COL)], // H
						$row[$col = Common::getNextData ($row, ($col + 1), $MAX_COL)], // M
						$row[$col = Common::getNextData ($row, ($col + 1), $MAX_COL)]); // S
						break;
					case 'Testee':
						$header['testee'] = array ('name' => $row[$col = Common::getNextData ($row, ($col + 1), $MAX_COL)], // name
						'id' => $row[$col = Common::getNextData ($row, ($col + 1), $MAX_COL)]); // id
						break;
						// body
					case 'QS':
						$col = Common::getNextData ($row, ($col + 1), $MAX_COL); // number of question
						if (count ($tmp_body_content) < 1) {
							$tmp_body_content['type'] = 'QS';
							$tmp_body_content['number'] = $row[$col];
						}
						$col = Common::getNextData ($row, ($col + 1), $MAX_COL); // SC or selection number
						if ($row[$col] == 'SC') { // diem so cung la cuoi mang
// 							$col = Common::getNextData ($row, ($col + 1), $MAX_COL);
// 							$tmp_body_content['score'] = $row[$col];
							$col = Common::getNextData ($row, ($col + 1), $MAX_COL);
							$scorej = $row[$col];
							$col = Common::getNextData ($row, ($col + 1), $MAX_COL);
							$timej = $row[$col];
							$tmp_body_content['score'] = array ($scorej, $timej);
							// add
							$body[] = $tmp_body_content;
							// reset data
							$tmp_body_content = array ();
						} else {
							$tmp_body_content[] = $row[$col];
						}
						break;
					case 'QW':
						$col = Common::getNextData ($row, ($col + 1), $MAX_COL);
						if (count ($tmp_body_content) < 1) {
							$tmp_body_content['type'] = 'QW';
							$tmp_body_content['number'] = $row[$col];
						}
						$col = Common::getNextData ($row, ($col + 1), $MAX_COL);
						$data = $row[$col];
							
						if ($data == 'INS') { // INS cung la cuoi mang
							for ($i = 0; $i < 2; $i ++) {
								$col = Common::getNextData ($row, ($col + 1), $MAX_COL);
								$tmp_body_content['INS'] = $row[$col];
							}
							// add
							$body[] = $tmp_body_content;
							// reset data
							$tmp_body_content = array ();
						} else if ($data == 'SC') {
							$col = Common::getNextData ($row, ($col + 1), $MAX_COL);
							$scorej = $row[$col];
							$col = Common::getNextData ($row, ($col + 1), $MAX_COL);
							$timej = $row[$col];
							$tmp_body_content['score'] = array ($scorej, $timej);
						} else {
							$tmp_body_content_index = $row[$col];
							$col_answer = Common::getNextData ($row, ($col + 1), $MAX_COL);
							$col_sc = Common::getNextData ($row, ($col_answer + 1), $MAX_COL);
							$tmp_body_content[$tmp_body_content_index] = array ($row[$col_answer], $row[$col_sc]);
						}
						break;
						// score/ answer
						// total score
					case 'TotalSC':
						$totalScore = $row[$col = Common::getNextData ($row, ($col + 1), $MAX_COL)];
						break;
					default:
						print_r ("Loi cmnr read file!");
						break;
				}
			}
		}
			
		fclose ($fp);
			
		return array ($header, $body, $totalScore);
	}

	/**
	 * 問題シートCSVファイルを読むメソッド
	 *
	 * $file name: ファイルの名前
	 *
	 * $param: $file name: /path/to/filename (.csv 無し)　ファイルのディレクトリ
	 *
	 * return test=>array(TestTitle,TestTestSubTitle,StartDateTime,EndDateTime,TestTime,TestType,TestTees,question)
	 * StartDateTime,EndDateTime =>array(y,m,d,h,mi,s)
	 * TestTees=>array(name,id,password)
	 * Question=>array(Q(*))
	 * Q(*)=>array(type,content,image_path,character_limit,answer_list,right_answer,AN(*),ANC,INS,list_score,timeout,LM)
	 * answer_list =>array(S(*))
	 * S(*)=>array(image_path,content)
	 * right_answer => array(AN(*))
	 * AN(*)=>array(type,list_right_answer=>array(S(*))
	 * LM=>array(type,time=>array(unit,value)
	 * if(LM[time]==TRAP) then LM=>array(type,time1,time2)
	 */
	public function readTestCSVFile($filepath, $param = null,$now = null) {

		//$file = $filepath.'.csv';
		$index = 0;
		$iscomment = false;
		if (($handle = fopen($filepath, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				// 				for ($data_i = count ($data); $data_i -- > 0;) {
				// 					$data_unicode = str_split($data[$data_i]);
				// 					$data[$data_i] = Common::unicodeToUtf8 ($data_unicode);
				// 					echo '<pre>';
				// 					print_r ($data[$data_i]);
				// 					echo '</pre>';
				// 				}

				$index++;
				// get Title
				if(preg_match('/^#/',$data[0]))
					continue;
				if(preg_match('/^\/\*/',$data[0]))
				{
					$iscomment=true;
				}
				if($iscomment)
				{
					for ($i=1;$i<count($data);$i++)
					{
						if(preg_match('/\/\*/',$data[$i]))
							return '行'.$index.': '.'comment 間違う' ;
						if(preg_match('/\*\//',$data[$i]))
						{
							$iscomment = false;
						}
					}
					continue;
				}
				if($data[0]!="" && !preg_match('/^#/',$data[0]) && !preg_match('/^\/\*/',$data[0]))
					if(!preg_match('/TestTitle/',$data[0]) && $data[0] != "TestSubTitle" && $data[0] != "StartDateTime" && $data[0] != "EndDateTime" && $data[0] != "TestTime" && $data[0] != "TestType" && $data[0] != "Testees" && !preg_match('/^Q\(\d*\)/', $data[0]) && $data[0]!="Estimate" && $data[0]!="Graphical" && $data[0]!="Trend" && $data[0]!="Ranking" && $data[0]!="Average" && $data[0]!="Histgram")
					{
						return '行'.$index.':'.'キー '.$data[0].'は違う';
					}
					if(preg_match('/TestTitle/',$data[0])){
						if($data[1]==""||!isset($data[1])||preg_match('/^#/',$data[1]))
							return '行'.$index.':'.'テストタイトルはない';
						$test_data['test']['TestTitle'] = $data[1];
					}
					else if($data[0] == "TestSubTitle")
					{
						if($data[1]==""||!isset($data[1])||preg_match('/^#/',$data[1]))
							return '行'.$index.':'.'テストサブタイトルはない';
						$test_data['test']['TestSubTitle'] = $data[1];
					}
					//start time :
					else if($data[0] == "StartDateTime")
					{
						for($i=1;$i<=6;$i++)
						{
							if(!isset($data[$i]))
							{
								return '行'.$index.': '.'時間は十分じゃない' ;
							}
							if(!is_numeric($data[$i]))
							{
								return '行'.$index.': '.'時間は番号' ;
							}

						}
						$test_data['test']['StartDateTime']= array(
								'y'=>$data[1],
								'm'=>$data[2],
								'd'=>$data[3],
								'h'=>$data[4],
								'mi'=>$data[5],
								's'=>$data[6]
						);
						$start_date_time = $test_data['test']['StartDateTime'];
						if(intval($start_date_time['m'])>12 || intval($start_date_time['m'])<1)
						{
							return '行'.$index.': '.'時間 MONTH は間違い';
						}
						if(intval($start_date_time['d'])>31 || intval($start_date_time['d'])<1)
						{
							return '行'.$index.': '.'時間 DAY は間違い';
						}
						if(intval($start_date_time['m'])==2)
						{
							if(intval($start_date_time['y'])%4 == 0)
							{
								if(intval($start_date_time['d'])>29)
								{
									return '行'.$index.': '.'時間 DAY は間違い';
								}
							}
							else
							{
								if(intval($start_date_time['d'])>28)
								{
									return '行'.$index.': '.'時間 DAY は間違い';
								}
							}
						}
						if(intval($start_date_time['m'])==4 || intval($start_date_time['m'])==6 || intval($start_date_time['m'])==9 || intval($start_date_time['m'])==11)
						{
							if(intval($start_date_time['d'])>30)
							{
								return '行'.$index.': '.'時間 DAY は間違い';
							}

						}
						if(intval($start_date_time['h'])>23 || intval($start_date_time['h'])<0)
						{
							return '行'.$index.': '.'時間 HOUR は間違い';
						}
						if(intval($start_date_time['mi'])>60 || intval($start_date_time['mi'])<0)
						{
							return '行'.$index.': '.'時間 MINUTE は間違い';
						}
						if(intval($start_date_time['s'])>60 || intval($start_date_time['s'])<0)
						{
							return '行'.$index.': '.'時間 SECOND は間違い';
						}
						$start_time = mktime(
								$test_data['test']['StartDateTime']['h'],
								$test_data['test']['StartDateTime']['mi'],
								$test_data['test']['StartDateTime']['s'],
								$test_data['test']['StartDateTime']['m'],
								$test_data['test']['StartDateTime']['d'],
								$test_data['test']['StartDateTime']['y']
						);
						if($now!=null)
							if(date("Y-m-d:H:i:s",$now[0])>=date("Y-m-d:H:i:s",$start_time)){
							return '行'.$index.': '.'スタートタイムは現在タイムより少ない';
						}
					}
					//get end time
					else if($data[0] == "EndDateTime")
					{
						for($i=1;$i<=6;$i++)
						{
							if(!is_numeric($data[$i]))
							{
								return '行'.$index.': '.'時間は番号' ;
							}
						}
						$test_data['test']['EndDateTime']= array(
								'y'=>$data[1],
								'm'=>$data[2],
								'd'=>$data[3],
								'h'=>$data[4],
								'mi'=>$data[5],
								's'=>$data[6]
						);
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
							$endDateTime = $test_data['test']['EndDateTime'];
							if(intval($endDateTime['m'])>12 || intval($endDateTime['m'])<1)
							{
								return '行'.$index.': '.'時間 MONTH は間違い';
							}
							if(intval($endDateTime['d'])>31 || intval($endDateTime['d'])<1)
							{
								return '行'.$index.': '.'時間 DAY は間違い';
							}
							if(intval($endDateTime['m'])==2)
							{
								if(intval($endDateTime['y'])%4 == 0)
								{
									if(intval($endDateTime['d'])>29)
									{
										return '行'.$index.': '.'時間 DAY は間違い';
									}
								}
								else
								{
									if(intval($endDateTime['d'])>28)
									{
										return '行'.$index.': '.'時間 DAY は間違い';
									}
								}
							}
							if(intval($endDateTime['m'])==4 || intval($endDateTime['m'])==6 || intval($endDateTime['m'])==9 || intval($endDateTime['m'])==11)
							{
								if(intval($endDateTime['d'])>30)
								{
									return '行'.$index.': '.'時間 DAY は間違い';
								}

							}
							if(intval($endDateTime['h'])>23 || intval($endDateTime['h'])<0)
							{
								return '行'.$index.': '.'時間 HOUR は間違い';
							}
							if(intval($endDateTime['mi'])>60 || intval($endDateTime['mi'])<0)
							{
								return '行'.$index.': '.'時間 MINUTE は間違い';
							}
							if(intval($endDateTime['s'])>60 || intval($endDateTime['s'])<0)
							{
								return '行'.$index.': '.'時間 SECOND は間違い';
							}
							$end_time = mktime(
									$endDateTime['h'],
									$endDateTime['mi'],
									$endDateTime['s'],
									$endDateTime['m'],
									$endDateTime['d'],
									$endDateTime['y']
							);
							if(date("Y-m-d:H:i:s",$end_time)<= date("Y-m-d:H:i:s",$start_time))
							{
								return 'エラー：終わり時間はスタート時間より少ない';
							}
						}
					}
					//get test time
					else if($data[0] == "TestTime")
					{
						if(!isset($data[1]) || intval($data[1])<=0)
						{
							return '行'.$index.': '.'時間はない' ;
						}
						if(!is_numeric($data[1]) )
						{
							return '行'.$index.': '.'時間は番号' ;
						}
						if(!isset($data[2]))
						{
							return '行'.$index.': '.'時間単位はない' ;
						}
						if($data[2]!="h" && $data[2]!="m" && $data[2]!="s")
						{
							return '行'.$index.': '.'時間単位は h/m/s' ;
						}
						$test_data['test']['TestTime']['value']= intval($data[1]);
						$test_data['test']['TestTime']['unit'] = $data[2];
					}
					else if($data[0] == "TestType")
					{
						if($data[1]!="Fix" && $data[1]!="Unfix")
						{
							return '行'.$index.': '.'テスト形はFix/Unfix' ;
						}
						$test_data['test']['TestType'] = $data[1];
					}
					else if($data[0] == "Testees")
					{
						for($i=1;$i<=6;$i++)
						{
							if(!isset($data[$i]))
							{
								return '行'.$index.': '.'回答者情報は十分じゃない' ;
							}
						}
						if($data[1]!="Name:")
						{
							return '行'.$index.'列2:'.'キー '.$data[1].'は適当じゃない';
						}
						if($data[3]!="ID:")
						{
							return '行'.$index.'列4:'.'キー '.$data[3].'は適当じゃない';
						}
						if($data[5]!="PW:")
						{
							return '行'.$index.'列6:'.'キー '.$data[5].'は適当じゃない';
						}
						if(!isset($data[2])||$data[2]=="")
						{
							return '行'.$index.':'.'回答者nameはない';
						}
						if(!isset($data[4])||$data[4]=="")
						{
							return '行'.$index.':'.'回答者IDはない';
						}
						if(!isset($data[6])||$data[6]=="")
						{
							return '行'.$index.':'.'回答者passwordはない';
						}
						$test_data['test']['Testees'][] = array(
								'name'=>$data[2],
								'id'=>$data[4],
								'password'=>$data[6]
						);
					}
					//question list data[test][question]
					else if(preg_match('/^Q\(\d*\)/', $data[0])) {

						if($data[1]!="QS" && $data[1]!="QW" && $data[1]!="FG" && !preg_match('/^WR\(\d*\)/', $data[1]) && !preg_match('/^S\(\d*\)/', $data[1]) && !preg_match('/^AN\(\d*\)/', $data[1]) && $data[1]!="ANC" && $data[1]!="INS" && !preg_match('/^SC\(\d*\)/', $data[1]) && $data[1]!="TM" && $data[1]!="LM")
						{
							return '行'.$index.': '.'キー　'.$data[1].'は違う' ;
						}
						//Kieu cua cau hoi test (QS: cau hoi trac nghiem; QW cau hoi tu luan)
						if($data[1]=="QS")
						{
							$test_data['test']['question'][$data[0]]['type'] = 'QS';
							$test_data['test']['question'][$data[0]]['content']=$data[2];
						}
						else if($data[1]=="QW")
						{

							$test_data['test']['question'][$data[0]]['type'] = 'QW';
							if($data[2] == "" || preg_match('/^#/',$data[2]))
							{
								return '行'.$index.': '.'内容はない' ;
							}
							$test_data['test']['question'][$data[0]]['content']=$data[2];
						}
						//image file path
						else if($data[1]=="FG"){
							$test_data['test']['question'][$data[0]]['image_path']=$data[2];
						}
						//limit character
						else if(preg_match('/^WR\(\d*\)/', $data[1]))
						{
							if(!is_numeric($data[2]))
							{
								return '行'.$index.': '.'値は番号' ;
							}
							$test_data['test']['question'][$data[0]]['character_limit'][$data[1]]=$data[2];
						}
						//answer list of QS
						else if(preg_match('/^S\(\d*\)/', $data[1]))
						{
							if($data[2]=="FG")
							{
								$test_data['test']['question'][$data[0]]['answer_list'][$data[1]]['image_path']=$data[3];
							}
							else
								$test_data['test']['question'][$data[0]]['answer_list'][$data[1]]['content'] = $data[2];
						}
						//right list answer
						else if(preg_match('/^AN\(\d*\)/', $data[1]))
						{
							if($data[2]!="KS" && $data[2]!="KSO"&& $data[2]!="KSA" && $data[2]!="KWA" && $data[2]!="KWAA" && $data[2]!="KWAO" && $data[2]!="KWP" && $data[2]!="KWPA" && $data[2]!="KWPO")
							{
								return '行'.$index.': '.'答えタイプは違う' ;
							}
							{

							}
							$test_data['test']['question'][$data[0]]['right_answer'][$data[1]]['type'] = $data[2];
							for ($i=3; $i< count($data);$i++)
							{
								if(preg_match('/^#/',$data[$i])|| preg_match('/^\/\*/',$data[$i])) break;
								$test_data['test']['question'][$data[0]]['right_answer'][$data[1]]['list_right_answer'][] = $data[$i];
							}
						}
						else if($data[1]=="ANC")
						{
							for($i=2;$i<count($data);$i++)
							{
								if(preg_match('/^#/',$data[$i]) || preg_match('/^\/\*/',$data[$i])) break;
								if(preg_match('/^AN\(\d*\)/', $data[$i]))
									$test_data['test']['question'][$data[0]]['ANC'][]=$data[$i];
							}
						}
						else if($data[1]=="INS")
						{
							if($data[2]!="CHK" && $data[2]!="CINP")
							{
								return '行'.$index.': '.'INSタイプは違う' ;
							}
							$test_data['test']['question'][$data[0]]['INS']=$data[2];
						}
						//list score of each answer
						else if(preg_match('/^SC/', $data[1]))
						{
							if(!preg_match('/^AN/', $data[2])&&$data[2]!="VINP")
							{
								return '行'.$index.': '.'点タイプは違う' ;
							}
							if(preg_match('/^AN/', $data[2]))
							{
								if(!is_numeric($data[3]))
								{
									return '行'.$index.': '.'点は番号' ;
								}
								$test_data['test']['question'][$data[0]]['list_score'][$data[2]] = $data[3];
							}
							//diem tu dong cham bang tay
							elseif ($data[2]=="VINP")
							{
								$test_data['test']['question'][$data[0]]['list_score'][$data[2]]="";
							}
						}
						//time out of each question
						else if($data[1]=="TM")
						{
							if(!is_numeric($data[2]))
							{
								return '行'.$index.': '.'時間は番号' ;
							}
							$test_data['test']['question'][$data[0]]['timeout']=$data[2];
						}
						else if($data[1]=="LM")
						{
							if($data[2]!="TRAP" && $data[2]!= "TRI" && $data[2]!="REC")
							{
								return '行'.$index.': '.'LMタイプは違う' ;
							}
							if($data[2]=="TRAP")
							{

								for($i=3;$i<=6;$i++)
								{
									if(!isset($data[$i]))
										return '行'.$index.': '.'時間情報はない' ;;
								}
								if(!is_numeric($data[3])&&!is_numeric($data[5])){
									return '行'.$index.': '.'時間は番号' ;
								}
								if($data[4]!="h" && $data[4]!="m" && $data[4]!="s")
								{
									return '行'.$index.': '.'時間タイプは違う' ;
								}
								if($data[6]!="h" && $data[6]!="m" && $data[6]!="s")
								{
									return '行'.$index.': '.'時間タイプは違う' ;
								}
								$test_data['test']['question'][$data[0]]['LM']['time1']['value']=$data[3];
								$test_data['test']['question'][$data[0]]['LM']['time1']['unit']=$data[4];
								$test_data['test']['question'][$data[0]]['LM']['time2']['value']=$data[5];
								$test_data['test']['question'][$data[0]]['LM']['time2']['unit']=$data[6];
							}
							else
							{
								if(!is_numeric($data[3])){
									return '行'.$index.': '.'時間は番号' ;
								}
								if($data[4]!="h" && $data[4]!="m" && $data[4]!="s")
								{
									return '行'.$index.': '.'時間タイプは違う' ;
								}
								$test_data['test']['question'][$data[0]]['LM']['time']['value']=$data[3];
								$test_data['test']['question'][$data[0]]['LM']['time']['unit']=$data[4];
							}
							$test_data['test']['question'][$data[0]]['LM']['type'] = $data[2];
						}
					}
			}
			fclose($handle);
			$i=0;
			if(!isset($test_data['test']['TestTitle']))
				return 'エラー：テストタイトルはない';
			if(!isset($test_data['test']['TestSubTitle']))
				return 'エラー：テストサブタイトルはない';
			if(!isset($test_data['test']['StartDateTime']))
				return 'エラー：スタートタイムはない';
			if(!isset($test_data['test']['EndDateTime']) && !isset($test_data['test']['TestTime']))
				return 'エラー：終わるタイムはない';
			if(!isset($test_data['test']['TestType']))
				return 'エラー：テストタイプはない';
			if(!isset($test_data['test']['Testees']))
				return 'エラー：回答者はない';
			foreach (array_keys($test_data['test']['question']) as $key)
			{
				if($test_data['test']['question'][$key]['type']=="QS")
				{
					if(isset($test_data['test']['question'][$key]['character_limit']))
					{
						return 'エラー：'.$key.' 質問タイプはQW';
					}
				}
				if($test_data['test']['question'][$key]['type']=="QW")
				{
					if(isset($test_data['test']['question'][$key]['answer_list']))
					{
						return 'エラー：'.$key.' 質問タイプはQS';
					}
				}
				if($test_data['test']['question'][$key]['type']=="QS")
					if(!isset($test_data['test']['question'][$key]['list_score']))
					{
						return 'エラー：'.$key.' list score は十分じゃない';
					}
					$i++;
					if($key!= "Q(".$i.")")  return 'エラー：Q('.$i.') はない';
					$j = 0;
					foreach (array_keys($test_data['test']['question'][$key]['list_score']) as $key1)
					{
						$j++;
						if($key1!= "AN(".$j.")" && $key1!="VINP")  return 'エラー：'.$key.' list score は間違う';
					}
					if($test_data['test']['question'][$key]['type']=="QS")
					{
						$k = 0;
						foreach (array_keys($test_data['test']['question'][$key]['answer_list']) as $key1)
						{
							$k++;
							if($key1!= "S(".$k.")")  return 'エラー：'.$key.' list answer は間違う';
						}
						foreach (array_keys($test_data['test']['question'][$key]['right_answer']) as $key1)
						{
							foreach (array_keys($test_data['test']['question'][$key]['right_answer'][$key1]['list_right_answer']) as $key2)
							{
								$val = $test_data['test']['question'][$key]['right_answer'][$key1]['list_right_answer'][$key2];
								if(!isset($test_data['test']['question'][$key]['answer_list'][$val]))
								{
									return 'エラー：'.$key.' list answer は十分じゃない';
								}
							}
						}
						$count = count($test_data['test']['question'][$key]['list_score']);
						if(isset($test_data['test']['question'][$key]['list_score']['VINP'])) $count=$count-1;
						if($count > count($test_data['test']['question'][$key]['right_answer']))
						{
							return 'エラー：'.$key.' list right answer は十分じゃない';
						}
						if($count < count($test_data['test']['question'][$key]['right_answer']))
						{
							return 'エラー：'.$key.' list score は十分じゃない';
						}
					}
			}
			switch($param) {
				case null:
					return $test_data;
					break;
				case 'test_name':
					return $test_data['test']['TestTitle'];
					break;
				case 'test_start_time':
					return mktime(
					$test_data['test']['StartDateTime']['h'],
					$test_data['test']['StartDateTime']['mi'],
					$test_data['test']['StartDateTime']['s'],
					$test_data['test']['StartDateTime']['m'],
					$test_data['test']['StartDateTime']['d'],
					$test_data['test']['StartDateTime']['y']
					);
					break;
				case 'test_end_time':
					if(!isset($test_data['test']['EndDateTime'])) {
						$test_data['test']['EndDateTime'] = Common::convertEnDateTime($test_data['test']['StartDateTime'], $test_data['test']['TestTime']);

					}
					return mktime(
							$test_data['test']['EndDateTime']['h'],
							$test_data['test']['EndDateTime']['mi'],
							$test_data['test']['EndDateTime']['s'],
							$test_data['test']['EndDateTime']['m'],
							$test_data['test']['EndDateTime']['d'],
							$test_data['test']['EndDateTime']['y']
					);
					break;
				case 'test_time':
					return $test_data['test']['TestTime'];
					break;
				case 'test_tees':
					return $test_data['test']['Testees'];
					break;
				case 'test_questions':
					return $test_data['test']['question'];
					break;
				default:
					return false;
			}
		}
		else {
			return false;
		}
	}

	/**
	 * CSVファイルに次のデータを抽出するメソッド
	 *
	 * @param array $row 抽出されている現在の行
	 * @param int $current_col　現在の列
	 * @param int $max_col　最高の列　（列の数マイナス１）
	 * @return int|number　データがある列
	 */
	public function getNextData ($row, $current_col, $max_col) {
		$col = $current_col;
		// 		while ($col < $max_col) {
		// 			if ($row[$col] == '') {
		// 				$col ++;
		// 				continue;
		// 			} else {
		// 				return $col;
		// 			}
		// 		}
		if ($col < $max_col) {
			return $col;
		}
		return -1;
	}
	public function getFileName($path) {
		$pos = strrpos($path, '/', 0);
		return $name = $pos ? substr($path, $pos+1) : $path;
	}
	public function convertEnDateTime($starTime,$testime)
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

	/**
	 * Xuat file CSV cho he thong 請求. file duoc luu trong demand_data/
	 *
	 * dinh dang dau vao $data
	 * $data = array ($thang_nam_thanh_toan, $ngay_thang_nam_gio_phut_giay_tao_file, $nguoi_tao_file, $danh_sach_thanh_toan)
	 *  - $thang_nam_thanh_toan = array (nam_thanh_toan, thang_thanh_toan)
	 *  - $ngay_thang_nam_gio_phut_giay_tao_file = array (nam_tao_file, thang_tao_file, ngay_tao_file, gio_tao_file, phut_tao_file, giay_tao_file)
	 *  - $nguoi_tao_file = array (id_nguoi_tao_file, ten_nguoi_tao_file)
	 *  - $danh_sach_thanh_toan = array ($thanh_toan_dantai1, $thanh_toan_dantai2..., $thanh_toan_dantain)
	 *     - $thanh_toan_dantai_i = array (id_dantai_i, ten_dantai_i, tong_so_tien_thanh_toan, dia_chi_cua_dantai_i, so_dien_thoai_cua_dantai_i)
	 */
	public function exportSeikyuData($data) {
		$filename = 'TAS-' . $data['date_cal']['y'] . '-' . $data['date_cal']['m'] . '.csv';
		$filepathname = 'demand_data/' . $filename;
		$fp = fopen($filepathname, 'w');
		// １行目
		$row = array ('CTS-TAS-GWK53M78', $data['date_cal']['y'], $data['date_cal']['m'],
				$data['date_cre']['y'], $data['date_cre']['m'], $data['date_cre']['d'], $data['date_cre']['hh'], $data['date_cre']['mm'], $data['date_cre']['ss'],
				$data['maker']['id'], $data['maker']['name']);
		fputcsv($fp, $row);
		// ２行目以降
		foreach ($data['list_cal'] as $row) {
			fputcsv ($fp, $row);
		}
		// 最後行目
		$row = array ('END___END___END', $data['date_cal']['y'], $data['date_cal']['m']);
		fputcsv ($fp, $row);
			
		fclose($fp);

		return $filename;
	}

	// convert utf8-unicode and unicdoe - utf8
	/**
	 * Takes an UTF-8 string and returns an array of ints representing the
	 * Unicode characters. Astral planes are supported ie. the ints in the
	 * output can be > 0xFFFF. Occurrances of the BOM are ignored. Surrogates
	 * are not allowed.
	 *
	 * Returns false if the input string isn't a valid UTF-8 octet sequence.
	 */
	function utf8ToUnicode(&$str)
	{
		$mState = 0;     // cached expected number of octets after the current octet
		// until the beginning of the next UTF8 character sequence
		$mUcs4  = 0;     // cached Unicode character
		$mBytes = 1;     // cached expected number of octets in the current sequence

		$out = array();

		$len = strlen($str);
		for($i = 0; $i < $len; $i++) {
			$in = ord($str{$i});
			if (0 == $mState) {
				// When mState is zero we expect either a US-ASCII character or a
				// multi-octet sequence.
				if (0 == (0x80 & ($in))) {
					// US-ASCII, pass straight through.
					$out[] = $in;
					$mBytes = 1;
				} else if (0xC0 == (0xE0 & ($in))) {
					// First octet of 2 octet sequence
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 0x1F) << 6;
					$mState = 1;
					$mBytes = 2;
				} else if (0xE0 == (0xF0 & ($in))) {
					// First octet of 3 octet sequence
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 0x0F) << 12;
					$mState = 2;
					$mBytes = 3;
				} else if (0xF0 == (0xF8 & ($in))) {
					// First octet of 4 octet sequence
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 0x07) << 18;
					$mState = 3;
					$mBytes = 4;
				} else if (0xF8 == (0xFC & ($in))) {
					/* First octet of 5 octet sequence.
					 *
					* This is illegal because the encoded codepoint must be either
					* (a) not the shortest form or
					* (b) outside the Unicode range of 0-0x10FFFF.
					* Rather than trying to resynchronize, we will carry on until the end
					* of the sequence and let the later error handling code catch it.
					*/
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 0x03) << 24;
					$mState = 4;
					$mBytes = 5;
				} else if (0xFC == (0xFE & ($in))) {
					// First octet of 6 octet sequence, see comments for 5 octet sequence.
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 1) << 30;
					$mState = 5;
					$mBytes = 6;
				} else {
					/* Current octet is neither in the US-ASCII range nor a legal first
					 * octet of a multi-octet sequence.
					*/
					return false;
				}
			} else {
				// When mState is non-zero, we expect a continuation of the multi-octet
				// sequence
				if (0x80 == (0xC0 & ($in))) {
					// Legal continuation.
					$shift = ($mState - 1) * 6;
					$tmp = $in;
					$tmp = ($tmp & 0x0000003F) << $shift;
					$mUcs4 |= $tmp;

					if (0 == --$mState) {
						/* End of the multi-octet sequence. mUcs4 now contains the final
						 * Unicode codepoint to be output
						*
						* Check for illegal sequences and codepoints.
						*/

						// From Unicode 3.1, non-shortest form is illegal
						if (((2 == $mBytes) && ($mUcs4 < 0x0080)) ||
								((3 == $mBytes) && ($mUcs4 < 0x0800)) ||
								((4 == $mBytes) && ($mUcs4 < 0x10000)) ||
								(4 < $mBytes) ||
								// From Unicode 3.2, surrogate characters are illegal
								(($mUcs4 & 0xFFFFF800) == 0xD800) ||
								// Codepoints outside the Unicode range are illegal
								($mUcs4 > 0x10FFFF)) {
							return false;
						}
						if (0xFEFF != $mUcs4) {
							// BOM is legal but we don't want to output it
							$out[] = $mUcs4;
						}
						//initialize UTF8 cache
						$mState = 0;
						$mUcs4  = 0;
						$mBytes = 1;
					}
				} else {
					/* ((0xC0 & (*in) != 0x80) && (mState != 0))
					 *
					* Incomplete multi-octet sequence.
					*/
					return false;
				}
			}
		}
		return $out;
	}

	/**
	 * Takes an array of ints representing the Unicode characters and returns
	 * a UTF-8 string. Astral planes are supported ie. the ints in the
	 * input can be > 0xFFFF. Occurrances of the BOM are ignored. Surrogates
	 * are not allowed.
	 *
	 * Returns false if the input array contains ints that represent
	 * surrogates or are outside the Unicode range.
	 */
	function unicodeToUtf8(&$arr)
	{
		$dest = '';
		foreach ($arr as $src) {
			if($src < 0) {
				return false;
			} else if ( $src <= 0x007f) {
				$dest .= chr($src);
			} else if ($src <= 0x07ff) {
				$dest .= chr(0xc0 | ($src >> 6));
				$dest .= chr(0x80 | ($src & 0x003f));
			} else if($src == 0xFEFF) {
				// nop -- zap the BOM
			} else if ($src >= 0xD800 && $src <= 0xDFFF) {
				// found a surrogate
				return false;
			} else if ($src <= 0xffff) {
				$dest .= chr(0xe0 | ($src >> 12));
				$dest .= chr(0x80 | (($src >> 6) & 0x003f));
				$dest .= chr(0x80 | ($src & 0x003f));
			} else if ($src <= 0x10ffff) {
				$dest .= chr(0xf0 | ($src >> 18));
				$dest .= chr(0x80 | (($src >> 12) & 0x3f));
				$dest .= chr(0x80 | (($src >> 6) & 0x3f));
				$dest .= chr(0x80 | ($src & 0x3f));
			} else {
				// out of range
				return false;
			}
		}
		return $dest;
	}

}

?>