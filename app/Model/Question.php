<?php
App::uses('AppModel', 'Model');
/**
 * Question Model
 *
 * @property User $User
 */
class Question extends AppModel {
	const UNTEST = 0;
	const TESTED = 1;
	const TESTING = 2;
	public static $status = array(
			Question::UNTEST => '未実行',
			Question::TESTED => '完了',
			Question::TESTING => '実装中',
	);
	public static $actions = array(
			Question::UNTEST => 'シミュレーション',
			Question::TESTED => '統計',
			Question::TESTING => 'レビュー',
	);
	/**
	 * Primary key field
	*
	* @var string
	*/
	public $primaryKey = 'question_id';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
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
			'path' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							//'message' => 'Your custom message here',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'test_link' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							//'message' => 'Your custom message here',
							//'allowEmpty' => false,
							//'required' => false,
	//'last' => false, // Stop validation after this rule
	//'on' => 'create', // Limit validation to 'create' or 'update' operations
	),
	),
	'start_date' => array(
	'date' => array(
	'rule' => array('datetime'),
	//'message' => 'Your custom message here',
	//'allowEmpty' => false,
	//'required' => false,
	//'last' => false, // Stop validation after this rule
	//'on' => 'create', // Limit validation to 'create' or 'update' operations
	),
	),
	'end_date' => array(
	'date' => array(
	'rule' => array('datetime'),
	//'message' => 'Your custom message here',
	//'allowEmpty' => false,
	//'required' => false,
	//'last' => false, // Stop validation after this rule
	//'on' => 'create', // Limit validation to 'create' or 'update' operations
	),
	),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
			'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			)
	);
}
