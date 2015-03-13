<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');
App::uses('Common', 'Lib');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	//set an alias for the newly created helper: Html<->MyHtml
	// public $helpers = array('Html' => array('className' => 'MyHtml'));
	public $helpers = array(
			'Session',
			'Html',
			'Form'
	);
	public $components = array(
			'Session',
			'Cookie',
			'Auth' => array(
					'authError' => '許可されません。',
					'loginRedirect' => array(
							'controller' => 'users',
							'action' => 'index'
					),
					'loginAction' => array(
							'controller' => 'users',
							'action' => 'index'
					),
					'authorize' => array('Controller')
			)
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->authenticate = array('Form');
	}

	public function beforeRender() {
		$this->layout = 'layoutmain';
	}

	public function isAuthorized($user = null) {
		if(isset($user['kind']) && $user['kind'] == 1 && $this->request->params['controller'] == 'sys_managers') {
			return true;
		}
		if(isset($user['kind']) && $user['kind'] == 1 && $this->request->params['controller'] == 'contracts') {
			return true;
		}
		if(isset($user['kind']) && $user['kind'] == 2 && $this->request->params['controller'] == 'org_managers') {
			if($this->Auth->user('del_flg') == 0) return true;
			elseif($this->request->params['action'] == 'index') {
				return true;
			}
		}
		if(isset($user['kind']) && $user['kind'] == 3 && $this->request->params['controller'] == 'test_markers') {
			if($this->Auth->user('del_flg') == 0) return true;
			elseif(in_array($this->request->params['action'], array('index', 'statistic', 'getAnswer'))) {
				return true;
			}
		}
		if(isset($user['kind']) && $user['kind'] == 4 && $this->request->params['controller'] == 'test_makers') {
			if($this->Auth->user('del_flg') == 0) return true;
			elseif(in_array($this->request->params['action'], array('index', 'statistic'))) {
				return true;
			}
		}
		return false;
	}
}
