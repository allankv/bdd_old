<?php
class Log_dq_fieldsAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'log_dq_fields';
    }
    public function rules() {
        return array();
    }
    public function relations() {
    	return array(
        	'log_dq' => array(self::BELONGS_TO, 'Log_dqAR', 'id_log_dq'),
    	);
    }
    public function attributeLabels() {
        return array();
    }
}

?>