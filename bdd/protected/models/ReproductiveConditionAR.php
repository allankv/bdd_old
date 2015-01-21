<?php
class ReproductiveConditionAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'reproductivecondition';
    }
    public function rules() {
        return array(
                array('reproductivecondition','length','max'=>60),
                array('reproductivecondition', 'required'),
                array('reproductivecondition', 'unique'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::HAS_MANY, 'OccurrenceElementAR', 'idreproductivecondition'),
        );
    }
    public function attributeLabels() {
        return array(
                'idreproductivecondition' => 'Reproductive condition ID',
                'reproductivecondition' => 'Reproductive condition',
        );
    }
}