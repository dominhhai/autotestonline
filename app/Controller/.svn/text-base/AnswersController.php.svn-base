<?php
App::uses('AppController', 'Controller');
/**
 * Answers Controller
 *
 * @property Answer $Answer
 */
class AnswersController extends AppController {

/**
 *　回答シートのindexメソッド
 *
 * @return void　無し
 */
	public function index() {
		$this->Answer->recursive = 0;
		$this->set('answers', $this->paginate());
	}

/**
 * 回答シートの情報を抽出するメソッド
 *
 * @throws NotFoundException　回答シートが存在ない場合、例外を出し
 * @param string $id　回答シートのID
 * @return void　無し
 */
	public function view($id = null) {
		if (!$this->Answer->exists($id)) {
			throw new NotFoundException(__('Invalid answer'));
		}
		$options = array('conditions' => array('Answer.' . $this->Answer->primaryKey => $id));
		$this->set('answer', $this->Answer->find('first', $options));
	}

/**
 * 回答シートを追加するメソッド
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Answer->create();
			if ($this->Answer->save($this->request->data)) {
				$this->Session->setFlash(__('回答シートを保存した。'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('回答シートが保存できない。もう一度確認ください！'));
			}
		}
		$questions = $this->Answer->Question->find('list');
		$this->set(compact('questions'));
	}

/**
 * 回答シートを編集するメソッド
 *
 * @throws NotFoundException　回答シートが存在ない場合、例外を出し
 * @param string $id　回答シートのID
 * @return void　無し
 */
	public function edit($id = null) {
		if (!$this->Answer->exists($id)) {
			throw new NotFoundException(__('Invalid answer'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Answer->save($this->request->data)) {
				$this->Session->setFlash(__('回答シートを保存した。'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('回答シートが保存できない。もう一度確認ください！'));
			}
		} else {
			$options = array('conditions' => array('Answer.' . $this->Answer->primaryKey => $id));
			$this->request->data = $this->Answer->find('first', $options);
		}
		$questions = $this->Answer->Question->find('list');
		$this->set(compact('questions'));
	}

/**
 * 回答シートを削除するメソッド
 *　
 * @throws NotFoundException　回答シートは存在無い場合、例外を出し
 * @throws MethodNotAllowedException　回答シートの削除禁止の場合、例外を出し
 * @param string $id　回答シートのID
 * @return void　無し
 */
	public function delete($id = null) {
		$this->Answer->id = $id;
		if (!$this->Answer->exists()) {
			throw new NotFoundException(__('Invalid answer'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Answer->delete()) {
			$this->Session->setFlash(__('回答シートを削除した。'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('回答シートが削除できない。'));
		$this->redirect(array('action' => 'index'));
	}
}
