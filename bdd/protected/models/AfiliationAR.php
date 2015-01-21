<?php
class AfiliationAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'afiliation';
    }
    public function rules() {
        return array(
                array('afiliation','required'),
                array('afiliation','unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referenceafiliation(idreferenceelement, idafiliation)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idafiliation' => 'Afiliation ID',
                'afiliation' => 'Afiliation'
        );
    }
}