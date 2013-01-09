<?php
class Slots extends CActiveRecord implements IAttributeTranslator {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'slots';
	}

	public function primaryKey() {
		return 'eventid';
	}

	public function getTranslatedAttribute($name) {
		if (!isset($name) || $name == null)
			return $name;
		 
		switch ($name) {
			case 'i':
			case 'id':
				return 'eventid';

			case 'd':
			case 'date':
				return 'datetime';
				
			case 'a':
			case 'action':
				return 'actiontype';
				
			case 'u':
			case 'user':
				return 'username';
				
			case 't':
				return 'item';
				
			case 'q':
				return 'quantity';
				
			case 'c':
				return 'container';
				
			case 'v':
				return 'inventory';
				
			default:
				return $name;
		}
	}

	public function rules() {
		return array(
			
		);
	}
}