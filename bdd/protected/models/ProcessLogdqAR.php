<?php
class ProcessLogdqAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'process_log_dq';
    }
    public function rules() {
        return array();
    }
	public function relations() {
       return array(
        	'type_log_dq' => array(self::BELONGS_TO, 'DataQualityTypesAR', 'id_last_task'),
       		'users' => array(self::BELONGS_TO, 'users', 'id_user'),
      		'log_dq' => array(self::HAS_MANY, 'Log_dq_AR ', 'id_log_dq')
        );
    }
    public function attributeLabels() {
        return array();
    }
}

?>