<?php
class AuthorYearOfScientificNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'authoryearofscientificname';
    }
    public function rules() {
        return array(
                array('authoryearofscientificname', 'required'),
                array('authoryearofscientificname', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idauthoryearofscientificname'),
        );
    }
    public function attributeLabels() {
        return array(
                'idauthoryearofscientificname'=>'Author year of scientific name ID',
                'authoryearofscientificname'=>'Author year of scientific name',
        );
    }
    /*
	 * M�todo que registra log no banco
    */
    public function behaviors() {
        return array(
                // Classname => path to Class
                'ActiveRecordLogableBehavior'=>
                'application.behaviors.ActiveRecordLogableBehavior',
        );
    }
}
