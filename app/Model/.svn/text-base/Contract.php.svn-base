<?php
App::uses('AppModel', 'Model');
/**
 * Contract Model
 *
 * @property Contract $Contract
 * @property User $User
 * @property Contract $Contract
 */
class Contract extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'contract_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'contract_id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'contract_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'start_date' => array(
			'notempty' => array(
						'rule' => array('notempty'),
						'message' => '[契約の初め]入力がありません。',
						//'allowEmpty' => false,
						//'required' => false,
						//'last' => false, // Stop validation after this rule
						//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'end_date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '[契約の完了]入力がありません。',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'contract_code' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'info' => array(
				'unique' => array(
							'rule' => array('isUnique'),
							'message' => '[団体名]既に登録されています。',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public function getUserContract($id)
	{
	$dataUser = $this->query("SELECT  Contract.contract_id,User.username FROM autotest.tb_contracts AS Contract LEFT JOIN autotest.tb_users AS User ON (User.id = Contract.user_id) WHERE User.id=$id");
	return $dataUser[0]['User']['username'];
	}

}
