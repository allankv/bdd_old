<?php
class FileAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'file';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'reference' => array(self::HAS_ONE, 'ReferenceAR', 'idfile'),
                'media' => array(self::HAS_ONE, 'MediaAR', 'idfile'),
        );
    }
    public function attributeLabels() {
        return array(
                'idfile' => 'File ID',
                'filename' => 'File name',
                'path' => 'Path',
                'filesistemname' => 'File sistem name',
                'size' => 'Size',
                'extension' => 'Extension',
        );
    }
}