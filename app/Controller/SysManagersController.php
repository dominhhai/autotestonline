<?php
App::uses ( 'AppController', 'Controller' );
/**
 * OrgManagers Controller
 *
 * @property OrgManager $OrgManager
*/
class SysManagersController extends AppController {
	var $uses = array ('User', 'Contract', 'OrgManager', 'Testee', 'Question', 'Answer');
	/**
	 * index method
	 *
	 * @return void
	*/
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('disable', 'check_contract'));
	}
	public function index() {
		if (isset ( $this->request->query ['username'] )) {
			$conditions = array ('kind' => 2, 'username like' => '%' . trim($this->request->query ['username'], ' ') . '%' );
		} else {
			$conditions = array ('kind' => 2 );
		}
		$this->paginate = array ('conditions' => $conditions, 'limit' => 10, 'order' => array ('id' => 'desc' ) );
		$org_managers = $this->paginate ( 'User' );
		$this->set ( 'org_managers', $org_managers );
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException'
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if($id == null)	{
			$this->redirect(array('action' => 'index'));
		}
		$user = $this->User->find('first', array('conditions' => array('id' => $id, 'kind' => 2)));
		$contract = $this->Contract->findByUserId($id);
		if($user == null)	{
			$this->Session->setFlash('ユーザーのIDが存在しません。');
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('user', 'contract'));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is ( 'post' )) {
			$data = $this->request->data;
			$this->User->set($data['User']);
			$this->Contract->set($data['Contract']);
			$check = $this->User->find('first', array('conditions' => array('username' => $data['User']['username'], 'kind' => 2)));
			if($check == null) {
				$this->User->validator()->remove('username', 'unique');
			}
			if($this->User->validates() && $this->Contract->validates()) {
				$data['User']['kind'] = 2;
				if(strtotime($data['Contract']['end_date']) >= strtotime('now') && strtotime($data['Contract']['start_date']) <= strtotime('now')) {
					$data['User']['del_flg'] = 0;
				} else {
					$data['User']['del_flg'] = 1;
				}
				$data['User']['password'] = $this->Auth->password($data['User']['password']);
				unset($data['User']['re_password']);
				$this->User->create();
				$this->User->save($data['User']);
				$data['Contract']['user_id'] = $this->User->id;
				$this->Contract->create();
				$this->Contract->save($data['Contract']);
				$this->Session->setFlash ( __ ( '団体管理者を登録しました。' ) );
				$this->redirect ( array ('action' => 'index' ) );
			}
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if($this->request->is('post') || $this->request->is('put')) {
			$this->User->id = $id;
			$this->User->save($this->request->data);
			$this->redirect(array('action' => 'view', $id));
		}
		if($id == null)	{
			$this->redirect(array('action' => 'index'));
		}
		$conditions = array('id' => $id, 'kind' => 2);
		$user = $this->User->find('first', array('conditions' => $conditions));
		if($user == null)	{
			$this->Session->setFlash('ユーザーのIDが存在しません。');
			$this->redirect(array('action' => 'index'));
		}
		$this->request->data = $user;
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @throws MethodNotAllowedException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		if($id == null)	{
			$this->redirect(array('action' => 'index'));
		}
		$conditions = array('id' => $id, 'kind' => 2);
		$user = $this->User->find('first', array('conditions' => $conditions));
		if($user != null) {
			//団体管理者を削除する
			$this->User->delete($id);
			$users = $this->OrgManager->find('all', array('conditions' => array('org_manager_id' => $id)));
			//採点者と出題者を削除する
			if(count($users) != null) {
				foreach ($users as $u) {
					$questions = $this->Question->find('all', array('conditions' => array('user_id' => $u['OrgManager']['user_id'])));
					foreach ($questions as $question) {
						//回答者とテストと回答者の答えを削除する
						$this->Testee->deleteAll(array('test_id' => $question['Question']['question_id']), false);
						$this->Answer->deleteAll(array('question_id' => $question['Question']['question_id']), false);
						$this->Question->delete($question['Question']['question_id']);
					}
					$this->User->delete($u['OrgManager']['user_id'], false);
				}
				$this->OrgManager->deleteAll(array('org_manager_id' => $id), false);
			}
			//契約を削除する
			$contract = $this->Contract->findByUserId($id);
			$this->Contract->delete($contract['Contract']['contract_id']);
		}
		$this->redirect(array('action' => 'index'));
	}

	public function enable($id = null) {
		$this->autoRender=false;
		if (empty($this->request->params['requested'])) {
			$this->redirect(array('action' => 'index'));
		}
		if($id == null)	{
			$this->redirect(array('action' => 'index'));
		}
		$conditions = array('id' => $id, 'kind' => 2, 'del_flg' => 1);
		$user = $this->User->find('first', array('conditions' => $conditions));
		if($user != null) {
			$this->User->id = $id;
			$this->User->saveField('del_flg', 0);
			$users = $this->OrgManager->find('all', array('conditions' => array('org_manager_id' => $id)));
			if($users != null) {
				foreach ($users as $u) {
					$this->User->id = $u['User']['id'];
					$this->User->saveField('del_flg', 0);
				}
			}
			return true;
		}
		return false;
	}

	public function disable($id = null) {
		$this->autoRender=false;
		if (empty($this->request->params['requested'])) {
			$this->redirect(array('action' => 'index'));
		}
		if($id == null)	{
			$this->redirect(array('action' => 'index'));
		}
		$conditions = array('id' => $id, 'kind' => 2, 'del_flg' => 0);
		$user = $this->User->find('first', array('conditions' => $conditions));
		if($user != null) {
			$this->User->id = $id;
			$this->User->saveField('del_flg', 1);
			$users = $this->OrgManager->find('all', array('conditions' => array('org_manager_id' => $id)));
			if($users != null) {
				foreach ($users as $u) {
					$this->User->id = $u['User']['id'];
					$this->User->saveField('del_flg', 1);
				}
			}
			return true;
		}
		return false;
	}
        
        public function payment()
        {
            date_default_timezone_set('Asia/Bangkok');
            $cost = intval(file_get_contents('cost/cost.txt'));
            $this->set('test_cost', $cost);
            $now = getdate();
            $this->set('current_year',$now['year']);
        }
	public function pay($year=null,$month=null)
	{
            $this->autoLayout = false;
		date_default_timezone_set('Asia/Bangkok');
		$now = getdate();
		$pay_month = $month;
		$pay_year = $year;
		$id=$this->Session->read('user_id');
		$user_name = $this->User->find('first',array('conditions'=>array('id'=>$id)));
		$user = array ('id'=>$id, 'name'=>$user_name['User']['firstname'].' '.$user_name['User']['lastname']);
		$this->set('user',$user);
		$this->set('now',$now);
		$this->set('pay_year', $pay_year);$this->set('pay_month', $pay_month);
		$list_org_id = $this->User->find('all',array(
				'conditions'=>array(
						'kind'=>2,
						'del_flg'=>0)
		));
		$org_list = array();
		foreach ($list_org_id as $org_id)
		{
			if (!isset ($org_id) || $org_id['User']['del_flg'] != 0) {
				continue;
			}
			$org['name'] = $org_id['User']['firstname'].' '.$org_id['User']['lastname'];
			$org['phone'] = $org_id['User']['phone'];
			$org['address'] = $org_id['User']['address'];
			$id = $org_id['User']['id'];
			$org['id'] = $id;
//			$testMakerIds = $this->OrgManager->find('all',array(
//					'fields'=>'user_id',
//					'conditions'=>array(
//							'org_manager_id'=>$id,
//							'User.kind'=>4)
//			));
			$total  = 0;
			$total=$this->Answer->find('count',array(
						'conditions'=>array(
								'org_manager_id'=>$id,
								'MONTH(upload_date)'=>$pay_month,
								'YEAR(upload_date)'=>$pay_year)
				));
			$org['testTotal'] = $total;
                        $costTotal = 0;
                        $tmp = $this->Answer->find('all',array(
                            'fields' =>array('sum(cost_per_test) as totalcost'),
                            'conditions'=>array(
                                                    'org_manager_id'=>$id,
                                                    'MONTH(upload_date)'=>$pay_month,
                                                    'YEAR(upload_date)'=>$pay_year)
				));
                        if(isset($tmp[0][0]['totalcost']))
                        {
                            $costTotal = $tmp[0][0]['totalcost'];
                        }
                        $org['costTotal']= $costTotal;
			$org_list[]=$org;
		}
		$this->set('org_list',$org_list);
	}
	public function process()
	{
		$this->autoRender = false;
		if($this->request->is('post'))
		{
			$data = $this->request->data;
			// 			echo '<pre>';
			// 			print_r($data);
			// 			echo '</pre>';
			$filename = Common::exportSeikyuData($data);
			//print_r ('export to '.$filename);
			// download this file
			  $filepathname = 'demand_data/' . $filename;
			  // open/save dialog box
			  header ('Content-Disposition: attachment; filename=' . $filename);
			  // content type
			  header ('Content-type: text/csv');
			  header ('Content-type: application/vnd.ms-excel');
			  header ('Content-Type: application/force-download');
			  header ('Content-Type: application/octet-stream');
			  header ('Content-Type: application/download');
			  header ('Content-Description: File Transfer');
			  header ('Content-Length: ' . filesize ($filepathname));
			  flush ();
			  // read from server and write to buffer
			  readfile ($filepathname);
			// back to index file
// 			  $this->Session->setFlash ('請求データを輸出しました。');
			$this->redirect(array('action'=>'index'));
		}
	}
	public function changeCost(){
		$cost = intval(file_get_contents('cost/cost.txt'));
		$this->set('cost',$cost);
		if($this->request->is('post'))
		{
			$data =  $this->request->data;
			if(is_numeric($data['newCost']))
			{
				file_put_contents('cost/cost.txt', $data['newCost']);
				
				$this->Session->setFlash ('１回テストのコストを変更できました。');
				$this->redirect(array('action'=>'payment'));
			}
			else
			{
				$this->Session->setFlash ('エラー：代金は数値じゃない。');
			}
		}
	}

	public function check_contract() {
		$contracts = $this->Contract->find('all');
		foreach ($contracts as $contract) {
			$now = strtotime('now');
			$end_contract = strtotime($contract['Contract']['end_date']);
			$limit = strtotime('-2 years');
			//$this->requestAction(array('controller' => 'sys_managers', 'action' => 'enable', $contract['Contract']['user_id']));
			if($now > $end_contract && $end_contract >= $limit) {
				$this->requestAction(array('controller' => 'sys_managers', 'action' => 'disable', $contract['Contract']['user_id']));
			} elseif($end_contract < $limit) {
				$id = $contract['Contract']['user_id'];
				$conditions = array('id' => $id, 'kind' => 2);
				$user = $this->User->find('first', array('conditions' => $conditions));
				if($user != null) {
					//団体管理者を削除する
					$this->User->delete($id);
					$users = $this->OrgManager->find('all', array('conditions' => array('org_manager_id' => $id)));
					//採点者と出題者を削除する
					if(count($users) != null) {
						foreach ($users as $u) {
							$questions = $this->Question->find('all', array('conditions' => array('user_id' => $u['OrgManager']['user_id'])));
							foreach ($questions as $question) {
								//回答者とテストと回答者の答えを削除する
								$this->Testee->deleteAll(array('test_id' => $question['Question']['question_id']), false);
								$this->Answer->deleteAll(array('question_id' => $question['Question']['question_id']), false);
								$this->Question->delete($question['Question']['question_id']);
							}
							$this->User->delete($u['OrgManager']['user_id'], false);
						}
						$this->OrgManager->deleteAll(array('org_manager_id' => $id), false);
					}
					//契約を削除する
					$contract = $this->Contract->findByUserId($id);
					$this->Contract->delete($contract['Contract']['contract_id']);
				}
			}
		}
		$this->autoRender = false;
	}
}
