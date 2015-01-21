<?php
class Log_dqAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'log_dq';
    }
    public function rules() {
        return array();
    }
	public function relations() {
       return array(
        	'log_dq_deleted_items' => array(self::BELONGS_TO, 'log_dq_deleted_itemsAR', 'id_log_dq_deleted_items'),
      		'type_log_dq' => array(self::BELONGS_TO, 'DataQualityTypesAR', 'id_type_log'),
      		'log_dq_fields' => array(self::HAS_MANY, 'Log_dq_fieldsAR ', 'id_log_dq'),
        );
    }
    public function attributeLabels() {
        return array();
    }
}

?>