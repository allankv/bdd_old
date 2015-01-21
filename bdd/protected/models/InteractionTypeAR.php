<?php
class InteractionTypeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'interactiontype';
    }
    public function rules() {
        return array(
                array('interactiontype', 'required'),
                array('interactiontype', 'unique'),
                array('interactiontype', 'exist'),
        );
    }
    public function relations() {
        return array(
            'interaction' => array(self::HAS_MANY, 'InteractionAR', 'idinteractiontype'),
        );
    }
    public function attributeLabels() {
        return array(
                'idinteractiontype'=>'Interaction type ID',
                'interactiontype'=>'Interaction type',
        );
    }
}