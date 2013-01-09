<?php
class PlayerPosition extends CActiveRecord implements IAttributeTranslator {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'playerlocation';
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
				
			case 'u':
			case 'user':
				return 'username';
				
			case 'm':
			case 'dim':
				return 'dimension';
				
			default:
				return $name;
		}
	}

	public function rules() {
		return array(
				
		);
	}
}