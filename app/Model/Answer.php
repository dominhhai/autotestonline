<?php
App::uses('AppModel', 'Model');
/**
 * Answer Model
 *
 * @property Question $Question
 */
class Answer extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'answer_id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'question_id' => array(
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
		'upload_date' => array(
			'datetime' => array(
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
//	public $belongsTo = array(
//		'Question' => array(
//			'className' => 'Question',
//			'foreignKey' => 'question_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
//	);
}
