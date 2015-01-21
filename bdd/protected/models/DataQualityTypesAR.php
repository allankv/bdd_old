<?php

class DataQualityTypesAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'type_log_dq';
    }
    public function rules() {
        return array(
                array('type_log_dq', 'required'),
                array('type_log_dq', 'unique'),
        );
    }
   
	public function relations() {
        return array(
        	'log_dq' => array(self::HAS_MANY, 'Log_dqAR', 'id_type_log'),
        );
    }
    
    public function attributeLabels() {
        return array(
                'id' => 'Type Name ID',
                'description' => 'Type Name',
        );
    }
}

?>
