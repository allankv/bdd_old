<?php
class PredominantBiomeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'predominantbiome';
    }
    public function rules() {
        return array(
                array('predominantbiome', 'required'),
                array('predominantbiome', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idpredominantbiome'),
        );
    }
    public function attributeLabels() {
        return array(
                'idpredominantbiome' => 'Predominant biome ID',
                'predominantbiome' => 'Predominant biome',
        );
    }
}