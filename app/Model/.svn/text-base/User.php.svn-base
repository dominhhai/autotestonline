<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Contract $Contract
 * @property OrgManager $OrgManager
 * @property Question $Question
 */
class User extends AppModel {
	const ADMIN = 1;
	const ORG_MANAGER = 2;
	const TEST_MARKER = 3;
	const TEST_MAKER = 4;
	public static $kind = array(
			User::ADMIN => 'マスター管理者',
			User::ORG_MANAGER => '団体管理者',
			User::TEST_MARKER => '出題者',
			User::TEST_MAKER => '採点者'
	);
	public $primaryKey = 'id';
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
			'username' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => '[ユザー名]入力がありません。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
					'unique' => array(
							'rule' => array('isUnique'),
							'message' => '[ユザー名]既に登録されています。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'password' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => '[パスワード]入力がありません。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
					'min' => array(
							'rule' => array('minLength', 6),
							'message' => '[パスワード]6文字以上で入力してください。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
// 					'max' => array(
// 							'rule' => array('maxLength', 32),
// 							'message' => '[パスワード]３２文字以下で入力してください。',
// 							//'allowEmpty' => false,
// 							//'required' => false,
// 							//'last' => false, // Stop validation after this rule
// 							//'on' => 'create', // Limit validation to 'create' or 'update' operations
// 					),
					'password_rule' => array(
							'rule' => "/^[a-zA-Z]+[0-9]+[a-zA-Z0-9]*$|^[0-9]+[a-zA-Z]+[a-zA-Z0-9]*$/",
							'message' => 'パスワードは、半角英数字にて入力可能です。英字と数字を少なくと１文字用いてください。'
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			're_password' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => '[パスワード]入力がありません。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
					'min' => array(
							'rule' => array('minLength', 6),
							'message' => '[パスワード]6文字以上で入力してください。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
					// 					'max' => array(
							// 							'rule' => array('maxLength', 32),
							// 							'message' => '[パスワード]３２文字以下で入力してください。',
							// 							//'allowEmpty' => false,
							// 							//'required' => false,
							// 							//'last' => false, // Stop validation after this rule
							// 							//'on' => 'create', // Limit validation to 'create' or 'update' operations
							// 					),
					'password_rule' => array(
							'rule' => "/^[a-zA-Z]+[0-9]+[a-zA-Z0-9]*$|^[0-9]+[a-zA-Z]+[a-zA-Z0-9]*$/",
							'message' => 'パスワードは、半角英数字にて入力可能です。英字と数字を少なくと１文字用いてください。'
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
					'check_pass' => array(
							'rule'    => 'checkPass',
            				'message' => '新規パスワードは一致しません。'
					)
			),
			'old_password' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => '[パスワード]入力がありません。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'firstname' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => '[名]入力がありません。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'lastname' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => '[姓]入力がありません。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'bank_account' => array(
					'numeric' => array(
							'rule' => array('numeric'),
							'message' => '銀行口座は、数字を入力してください。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
					'max' => array(
							'rule' => array('maxLength', 20),
							'message' => '[銀行口座]20数字以下で入力してください。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'info' => array(
					//'notempty' => array(
					//'rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
					//),
			),
			'address' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => '[アドレス]入力がありません。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'phone' => array(
					'phone' => array(
							'rule' => array('phone', '^\+(?:[0-9] ?){6,14}[0-9]$^'),
							'message' => '電話番号の形式が違います。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'kind' => array(
					//'numeric' => array(
					//'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
					//),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public function checkPass($check) {
		//return ($check == $this->data['User']['re_password']);
		$result = strcmp($check['re_password'], $this->data['User']['password']);
		if($result == 0) return true;
		return false;
	}
	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
			'Contract' => array(
					'className' => 'Contract',
					'foreignKey' => 'user_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
			),
			'OrgManager' => array(
					'className' => 'OrgManager',
					'foreignKey' => 'user_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
			),
			'Question' => array(
					'className' => 'Question',
					'foreignKey' => 'user_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
			)
	);

}
