<?php
class ProcessSpecimensExecutionAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'process_specimens_execution';
    }
    public function rules() {
        return array();
    }
	public function relations() {
       return array(
        	'type_log_dq' => array(self::BELONGS_TO, 'DataQualityTypesAR', 'id_log_dq'),
      		'specimen' => array(self::BELONGS_TO, 'SpecimenAR', 'id_specimen'),
      		'process_log_dq' => array(self::BELONGS_TO, 'ProcessLogdqAR', 'id_process'),
        );
    }
    public function attributeLabels() {
        return array();
    }
}

?>