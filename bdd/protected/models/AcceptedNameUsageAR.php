<?php
class AcceptedNameUsageAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'acceptednameusage';
    }
    public function rules() {
        return array(
                array('acceptednameusage','length','max'=>120),
                array('acceptednameusage','required'),
                array('acceptednameusage','unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelements' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idacceptednameusage'),
        );
    }
    public function attributeLabels() {
        return array(
                'idacceptednameusage' => 'Accepted name usage ID',
                'acceptednameusage' => 'Accepted name usage',
        );
    }
}