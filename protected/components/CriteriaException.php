<?php
class CriteriaException extends CException {
	
	const INVALID_DATATYPE = 0;
	const INVALID_FORMAT = 1;
	const INVALID_OPERATOR = 2;
	const INVALID_FIELD = 3;
	const INVALID_FIELD_VALUE = 4;
	
	public $criteria;
	public $operator;
	public $name;
	public $value;
	
	public function __construct($code, $criteria, $operator = null, $name = null, $value = null) {
		$this->criteria = $criteria;
		$this->operator = $operator;
		$this->name = $name;
		$this->value = $value;
		
		switch ($code) {
			case self::INVALID_FORMAT:
				$message = 'Invalid criteria format';
				break;
			case self::INVALID_OPERATOR:
				$message = 'Invalid criteria operator: ' . $operator;
				break;
			case self::INVALID_FIELD:
				$message = 'Invalid criteria field name: ' . $name;
				break;
			case self::INVALID_FIELD_VALUE:
				$message = 'Invalid value for criteria \'' . $name . '\': ' . $value;
				break;
			default:
				$message = 'Unknown exception code: ' . $code;
		}
		
		parent::__construct($message, $code);
	}
	
	public function CodeAsString($code) {
		switch ($code) {
			case self::INVALID_DATATYPE: return 'INVALID_DATATYPE';
			case self::INVALID_FORMAT: return 'INVALID_FORMAT';
			case self::INVALID_OPERATOR: return 'INVALID_OPERATOR';
			case self::INVALID_FIELD: return 'INVALID_FIELD';
			case self::INVALID_FIELD_VALUE: return 'INVALID_FIELD_VALUE';
		}
	}
}