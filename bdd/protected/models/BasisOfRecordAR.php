<?php
class BasisOfRecordAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'basisofrecord';
    }
    public function rules() {
        return array(
                array('basisofrecord','required'),
                array('basisofrecord','exist'),
        );
    }
    public function relations() {
        return array(
            'recordlevelelement' => array(self::HAS_MANY, 'BasisOfRecordAR', 'idbasisofrecord'),
        );
    }
    public function attributeLabels() {
        return array(
                'idbasisofrecord'=>'Basis of record ID',
                'basisofrecord'=>'Basis of record',
        );
    }
}