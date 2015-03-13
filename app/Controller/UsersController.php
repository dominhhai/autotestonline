<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public $uses = array('User','OrgManager', 'Question', 'Testee', 'Contract');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('logout','login','index', 'change_pass'));
	}

	public function login($id1 = null, $id2= null) {
		if($this->Session->read('logged_in')){
			$this->redirect(array('action' => 'logout'));
		}
		if($id1 == null && $id2 == null){
			if ($this->request->is('post')) {
				if ($this->Auth->login()) {
					$user = $this->Auth->user();
					if(in_array($user['kind'], array(2,3,4))) {
						$this->Session->setFlash('IDまたはパスワードが違います。');
						$this->redirect($this->Auth->logout());
					}
					$this->Session->write('logged_in', true);
					$this->Session->write('username', $user['username']);
					$this->Session->write('kind', $user['kind']);
					$this->Session->write('user_id', $user['id']);
					$this->Session->setFlash('ログインできました');
					$this->redirect(array('controller' => 'sys_managers'));
				} else {
					$this->Session->setFlash(__('IDまたはパスワードが違います。'), 'default', array(), 'auth');
				}
			}
		} elseif($id1 != null && $id2 == null) {
			if ($this->request->is('post')) {
				$contract = $this->Contract->findByInfo($id1);
				if(!$contract) {
					$this->Session->setFlash('リンクは違います。');
				} else {
					$data = $this->request->data;
					$conditions1 = array(
							'username' => $data['User']['username'],
							'password' => AuthComponent::password($data['User']['password']),
							'id' => $contract['Contract']['user_id'],
					);
					$conditions2 = array(
							'username' => $data['User']['username'],
							'password' => AuthComponent::password($data['User']['password']),
							'org_manager_id' => $contract['Contract']['user_id'],
					);
					if (($user = $this->User->find('first', array('conditions' => $conditions1))) == null) {
						$user = $this->OrgManager->find('first', array('conditions' => $conditions2));
					}
					if($user != null) {
						$this->Session->write('logged_in', true);
						$this->Session->write('username', $user['User']['username']);
						$this->Session->write('kind', $user['User']['kind']);
						$this->Session->write('user_id', $user['User']['id']);
						$this->Auth->login($user['User']);
						$this->Session->setFlash('ログインできました');
						switch ($user['User']['kind']) {
							case 2:
								return $this->redirect(array('controller' => 'org_managers'));
								break;
							case 3:
								return $this->redirect(array('controller' => 'test_markers'));
								break;
							case 4:
								return $this->redirect(array('controller' => 'test_makers'));
								break;
						}
					} else {
						$this->Session->setFlash(__('IDまたはパスワードが違います。'), 'default', array(), 'auth');
					}
				}
			}
		} elseif($id1 != null && $id2 != null)
		{
			$tmp = $this->Question->find('first',array(
					'conditions'=>array('question_id'=>$id2)));
			if($tmp != null) {
				$testTitle = Common::readTestCSVFile($tmp['Question']['path'], 'test_name');
				$this->set('testTitle',$testTitle);
				$org_id = $this->OrgManager->find('first',array(
						'fields'=>array('org_manager_id'),
						'conditions'=>array('user_id'=>$tmp['User']['id'])
				));
				$org_manager = $this->User->find('first',array(
						'conditions'=>array('id'=>$org_id['OrgManager']['org_manager_id'])
				));
				$this->set('orgFirstName',$org_manager['User']['firstname']);
				$this->set('orgLastName',$org_manager['User']['lastname']);
			}
			if($id1 != 'test') {
				$this->Session->setFlash(__('テストリンクは間違います。'));
			} elseif(!isset($testTitle)){
				$this->Session->setFlash(__('テストリンクは間違います。団体が存在しません。'));
			}else {
				if($this->request->is('post')){
					$data = $this->request->data;
					$conditions = array(
							'username' => $data['User']['username'],
							'password' => AuthComponent::password($data['User']['password']),
							'test_id' => $id2,
					);
					$testee = $this->Testee->find('first', array('conditions' => $conditions));
					if($testee) {
						if($testee['Testee']['flag'] == 1) {
							$this->Session->setFlash(__('このアカウントがログインしています。'));
						} else {
							$test = $this->Question->findByQuestionId($testee['Testee']['test_id']);
							if($test != null) {
								if($org_manager['User']['del_flg'] == 0) {
									$this->Session->write('logged_in', true);
									$this->Session->write('testtee', $testee);
									$this->Session->write('kind',  0);
									$this->Session->write('test_id',$id2);
									$this->Session->write('org_id', $org_id['OrgManager']['org_manager_id']);
									$this->Auth->login($testee['Testee']);
									$this->Testee->id = $testee['Testee']['id'];
									$this->Testee->saveField('flag', 1);
									$this->Session->setFlash('ログインできました');
									$this->redirect(array('controller' => 'test_tees', 'action' => 'index'));
								} else{
									$this->Session->setFlash(__('アカウントはログインできない。'));
								}
							} else {
								$this->Session->setFlash(__('テストID が違う、またはこのアカウントがログインしました。'));
							}
						}
					} else {
						$this->Session->setFlash(__('IDまたはパスワードが違います。'), 'default', array(), 'auth');
					}
				}
			}
		} else {
			$this->Session->setFlash(__('テストリンクは間違います。'));
		}
	}

	public function logout() {
		$kind = $this->Session->read('kind');
		$user_id = $this->Auth->user('id');
		if($kind == 0) {
			$test_id = $this->Session->read('test_id');
			$this->Testee->id = $this->Auth->user('id');
			$this->Testee->saveField('flag', 0);
		} 
		$this->Session->destroy();
		//$this->Auth->logout();
		if($kind == 0) {
			$this->redirect(array('action' => 'login', 'test', $test_id));
		} else if($kind == 1){
			$this->redirect(array('action' => 'login'));
		} else if($kind == 2){
			$org_name = $this->Contract->find('first', array('conditions' => array('user_id' => $user_id)));
			$this->redirect(array('action' => 'login', $org_name['Contract']['info']));
		} else {
			$org_id = $this->OrgManager->find('first',array(
						'fields'=>array('org_manager_id'),
						'conditions'=>array('user_id'=>$user_id)
			));
			$org_name = $this->Contract->find('first', array('conditions' => array('user_id' => $org_id['OrgManager']['org_manager_id'])));
			$this->redirect(array('action' => 'login', $org_name['Contract']['info']));
		}
		
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->redirect(array('action' => 'login'));
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	public function change_pass() {
		if($this->Session->read('logged_in') && ($this->Session->read('kind') != 0)) {
			if($this->request->is('post')) {
				$data = $this->request->data;
				$user = $this->User->findById($this->Auth->user('id'));
				$this->User->set($data);
				if($this->User->validates()) {
					if(AuthComponent::password($data['User']['old_password']) == $user['User']['password']) {
						$this->User->id = $user['User']['id'];
						$this->User->saveField('password', AuthComponent::password($data['User']['password']));
						$this->Session->destroy();
						$this->Session->setFlash('パスワードは変更しました。またログインしてください。');
						$this->redirect($this->Auth->logout());
					}
					else {
						$this->Session->setFlash('パスワードが間違います。');
					}
				}
			}
		} elseif ($this->Session->read('logged_in') && ($this->Session->read('kind') != 0)) {
			$this->Session->setFlash('パスワードが変更できません。');
			$this->redirect(array('controller' => 'test_tees'));
		} else {
			$this->Session->setFlash('あなたはログインしていない。');
			$this->redirect(array('action' => 'login'));
		}
	}
}