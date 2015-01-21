<?php
class CuratorialAssociatedSequenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'curatorialassociatedsequence';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'associatedsequencenn' => array(self::BELONGS_TO, 'AssociatedSequenceAR', 'idpreparation'),
                'curatorialelementnn' => array(self::BELONGS_TO, 'CuratorialElementAR', 'idcuratorialelement'),

        );
    }
    public function attributeLabels() {
        return array(
                'idassociatedsequence' => 'Associated sequence ID',
                'idcuratorialelement' => 'Curatorial element ID',
        );
    }
}