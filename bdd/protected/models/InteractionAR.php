<?php

class InteractionAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'interaction';
    }
    public function rules() {
        return array(
                array('idspecimen1, idspecimen2,  idinteractiontype', 'required'),
                array('idspecimen1, idspecimen2', 'numerical', 'integerOnly'=>true),
        );
    }
    public function relations() {
        return array(
                'specimen1' => array(self::BELONGS_TO, 'SpecimenAR', 'idspecimen1'),
                'specimen2' => array(self::BELONGS_TO, 'SpecimenAR', 'idspecimen2'),
                'interactiontype' => array(self::BELONGS_TO, 'InteractionTypeAR', 'idinteractiontype'),
        		'groups' => array(self::BELONGS_TO, 'groups', 'idGroup'),
        );
    }
    public function attributeLabels() {
        return array(
                'idinteractionelements'=>'Interaction',
                'idspecimen1'=>'Specimen 1',
                'idspecimen2'=>'Specimen 2',
                'idinteractiontype'=>'Interaction type',
                'interactionrelatedinformation'=>'Interaction related information',
                'modified'=>'Last modified',
        );
    }
}