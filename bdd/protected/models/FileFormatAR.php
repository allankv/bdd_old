<?php
class FileFormatAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'fileformat';
    }
    public function rules() {
        return array(
                array('fileformat','length','max'=>10),
                array('fileformat', 'required'),
        );
    }
    public function relations() {
        return array(
                'reference' => array(self::HAS_MANY, 'ReferenceAR', 'idfileformat'),
                'media' => array(self::HAS_MANY, 'MediaAR', 'idfileformat'),
        );
    }
    public function attributeLabels() {
        return array(
                'idfileformat' => 'File format ID',
                'fileformat' => 'File format',
        );
    }
}