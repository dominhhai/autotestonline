<?php
App::uses ( 'AppController', 'Controller' );
class TestManageController extends AppController {
   var $uses = array('User', 'Question','Answer','OrgManager');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
        public function get_test()
        {
            date_default_timezone_set('Asia/Bangkok');
             $now = getdate();
            $this->autoRender = false;
            $data = Common::readTestCSVFile('datatest/PTFX01-N01.csv',null,$now);
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
}
