<?php
App::uses('AppController', 'Controller');
/**
 * Contracts Controller
 *
 * @property Contract $Contract
 */
class ContractsController extends AppController {

	public $uses = array('Contract','User');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		if(isset($this->request->query['info'])){
			$conditions = array(
					'info like' => '%'.$this->request->query['info'].'%',
			);
		} else {
			$conditions = array();
		}
		$this->paginate = array(
				'conditions' => $conditions,
				'limit' => 10,
				'order' => array('id' => 'desc')
		);
		$contracts = $this->paginate();
		foreach ($contracts as $key => $contract) {
			$user = $this->User->findById($contract['Contract']['user_id']);
			if($user == null) {
				unset($contracts[$key]);
			}
			else $contracts[$key]['Contract']['username'] = $user['User']['firstname'].' '.$user['User']['lastname'];
		}
		if($contracts == null) {
			$this->Session->setFlash('契約が見つかりません');
		}
		$this->set('contracts', $contracts);
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if($id != null) {
			$contract = $this->Contract->findByContractId($id);
			if($contract != null){
				$user = $this->User->findById($contract['Contract']['user_id']);
			} 
			if(isset($user) && $user != null) {
				$contract['Contract']['username'] = $user['User']['firstname'].' '.$user['User']['lastname'];
				$this->set('contract', $contract);
			} else {
				$this->Session->setFlash('契約は存在しません。');
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$this->redirect(array('action' => 'index'));
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
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Contract->save($this->request->data)) {
				$data = $this->request->data;
				if(strtotime($data['Contract']['end_date']) >= strtotime('now') && strtotime($data['Contract']['start_date']) <= strtotime('now')) {
					$this->requestAction(array('controller' => 'sys_managers', 'action' => 'enable', $data['Contract']['user_id']));
				} else {
					$this->requestAction(array('controller' => 'sys_managers', 'action' => 'disable', $data['Contract']['user_id']));
				}
				$this->Session->setFlash(__('契約を編集した。'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('契約を編集できない。ご確認ください。'));
			}
		}
		if($id == null) {
			$this->redirect(array('action' => 'index'));
		}
		$contract = $this->Contract->findByContractId($id);
		if($contract != null){
			$user = $this->User->findById($contract['Contract']['user_id']);
		}
		if(!isset($user) || $user == null) {
			$this->Session->setFlash('契約は存在しません。');
			$this->redirect(array('action' => 'index'));
		}
		$this->request->data = $contract;
		//$users = $this->User->find('list', array('conditions' => array('kind' => 2), 'fields' => array('id', 'username')));
		//$this->set(compact('users'));
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
		if($id != null)	{
			$contract = $this->Contract->findByContractId($id);
			if($contract != null) {
				$this->Contract->id = $id;
				$this->Contract->delete();
			}
		}
		$this->redirect(array('action' => 'index'));
	}
}
