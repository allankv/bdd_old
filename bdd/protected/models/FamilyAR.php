<?php
class FamilyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'family';
    }
    public function rules() {
        return array(
                array('family', 'required'),
                array('family', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idfamily'),
        );
    }
    public function attributeLabels() {
        return array(
                'idfamily'=>'Family ID',
                'family'=>'Family',
        );
    }
    /*
	 * Metodo que registra log no banco
    */
    public function behaviors() {
        return array(
                // Classname => path to Class
                'ActiveRecordLogableBehavior'=>
                'application.behaviors.ActiveRecordLogableBehavior',
        );
    }
}