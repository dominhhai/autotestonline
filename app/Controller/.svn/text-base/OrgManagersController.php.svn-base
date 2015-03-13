<?php
App::uses ( 'AppController', 'Controller' );
/**
 * OrgManagers Controller
 *
 * @property OrgManager $OrgManager
 */
class OrgManagersController extends AppController {
	var $uses = array ('OrgManager', 'User' );
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
	}

	public function test_maker_manage(){
		if(isset($this->request->query['username'])){
			$conditions = array(
					'org_manager_id' => $this->Session->read('user_id'),
					'kind' => 4,
					'username like' => '%'.trim($this->request->query['username'], ' ').'%',
			);
		} else {
			$conditions = array('org_manager_id' => $this->Session->read('user_id'), 'kind' => 4);
		}
		$this->paginate = array(
				'conditions' => $conditions,
				'limit' => 10,
				'order' => array('id' => 'desc')
		);
		$test_makers = $this->paginate('OrgManager');
		if($test_makers == null) {
			$this->Session->setFlash('ユーザーが見つかりません');
		}
		$this->set('test_makers', $test_makers);
	}

	public function test_marker_manage(){
		if(isset($this->request->query['username'])){
			$conditions = array(
					'org_manager_id' => $this->Session->read('user_id'),
					'kind' => 3,
					'username like' => '%'.$this->request->query['username'].'%',
			);
		} else {
			$conditions = array('org_manager_id' => $this->Session->read('user_id'), 'kind' => 3);
		}
		$this->paginate = array(
				'conditions' => $conditions,
				'limit' => 10,
				'order' => array('id' => 'desc')
		);
		$test_markers = $this->paginate('OrgManager');
		if($test_markers == null) {
			$this->Session->setFlash('ユーザーが見つかりません');
		}
		$this->set('test_markers', $test_markers);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add_test_maker() {
		if ($this->request->is ( 'post' )) {
			$data = $this->request->data;
			$this->User->set($data);
			$conditions = array('username' => $data['User']['username'], 'kind' => array(3,4), 'OrgManager.org_manager_id' => $this->Session->read('user_id'));
			$check = $this->OrgManager->find('first', array('conditions' => $conditions));
			if($check == null) {
				$this->User->validator()->remove('username', 'unique');
			}
			if($this->User->validates()) {
				$data['User']['kind'] = 4;
				$data['User']['password'] = $this->Auth->password($data['User']['password']);
				unset($data['User']['re_password']);
				$this->User->create();
				$this->User->save($data);
				$this->OrgManager->create();
				$this->OrgManager->save(array('org_manager_id' => $this->Session->read('user_id'), 'user_id' => $this->User->id));
				mkdir('test/'.$this->User->id);
				$this->Session->setFlash ( __ ( '新出題者を登録しました。' ) );
				$this->redirect ( array ('action' => 'test_maker_manage' ) );
			}
		}
	}

	public function add_test_marker() {
	if ($this->request->is ( 'post' )) {
			$data = $this->request->data;
			$this->User->set($data);
			$conditions = array('username' => $data['User']['username'], 'kind' => array(3,4), 'OrgManager.org_manager_id' => $this->Session->read('user_id'));
			$check = $this->OrgManager->find('first', array('conditions' => $conditions));
			if($check == null) {
				$this->User->validator()->remove('username', 'unique');
			}
			if($this->User->validates()) {
				$data['User']['kind'] = 3;
				$data['User']['password'] = $this->Auth->password($data['User']['password']);
				unset($data['User']['re_password']);
				$this->User->create ();
				$this->User->save($data);
				$this->OrgManager->create();
				$this->OrgManager->save(array('org_manager_id' => $this->Session->read('user_id'), 'user_id' => $this->User->id));
				mkdir('answer_sheet/'.$this->User->id);
				$this->Session->setFlash ( __ ( '新採点者を登録しました。' ) );
				$this->redirect ( array ('action' => 'add_test_marker' ) );
			}
		}
	}
	public function view($id = null) {
		if($id == null)	{
			$this->redirect(array('action' => 'index'));
		}
		$conditions = array('id' => $id, 'kind' => array(3,4), 'OrgManager.org_manager_id' => $this->Session->read('user_id'));
		$user = $this->OrgManager->find('first', array('conditions' => $conditions));
		if($user == null)	{
			$this->Session->setFlash('ユーザーのIDが存在しません。');
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('user'));
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
		$conditions = array('id' => $id, 'kind' => array(3,4), 'OrgManager.org_manager_id' => $this->Session->read('user_id'));
		$user = $this->OrgManager->find('first', array('conditions' => $conditions));
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
		$conditions = array('id' => $id, 'kind' => array(3,4), 'OrgManager.org_manager_id' => $this->Session->read('user_id'));
		$user = $this->OrgManager->find('first', array('conditions' => $conditions));
		if($user != null) {
			$this->User->id = $id;
			$this->User->delete();
			$this->OrgManager->deleteAll(array('org_manager_id' => $this->Session->read('user_id'), 'user_id' => $id), false);
		}
		if($user['User']['kind'] == 3) {
			$this->redirect(array('action' => 'test_marker_manage'));
		} elseif ($user['User']['kind'] == 4) {
			$this->redirect(array('action' => 'test_maker_manage'));
		}
	}
}
