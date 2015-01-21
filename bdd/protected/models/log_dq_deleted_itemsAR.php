<?php
class log_dq_deleted_itemsAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'log_dq_deleted_items';
    }
    public function rules() {
        return array();
    }
    public function relations() {
        return array(
        	'log_dq' => array(self::HAS_MANY, 'Log_dqAR', 'id_log_dq_deleted_items'),
        );
    }
    public function attributeLabels() {
        return array();
    }
}

?>