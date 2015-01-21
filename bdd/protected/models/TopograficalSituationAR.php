<?php
class TopograficalSituationAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'topograficalsituation';
    }
    public function rules() {
        return array(
                array('topograficalsituation', 'required'),
                array('topograficalsituation', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idtopograficalsituation'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtopograficalsituation' => 'Topographical situation ID',
                'topograficalsituation' => 'Topographical situation',
        );
    }
}
?>