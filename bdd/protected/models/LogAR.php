<?php

class LogAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'log';
    }
    public function rules() {
        return array();
    }
    public function relations() {
        return array(
			'groups' => array(self::BELONGS_TO, 'groups', 'idGroup'),
			
		);
    }
    public function attributeLabels() {
        return array();
    }
}

?>