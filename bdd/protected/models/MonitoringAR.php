<?php
class MonitoringAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'monitoring';
    }
    public function rules() {
        return array(
                array('plotnumber','numerical','integerOnly'=>true),
                array('amostralnumber','numerical','integerOnly'=>true),
                array('floorheight','numerical','integerOnly'=>false),
                array('weight','numerical','integerOnly'=>false),
                array('width','numerical','integerOnly'=>false),
                array('length','numerical','integerOnly'=>false),
                array('height','numerical','integerOnly'=>false),
                array('installationtime','myCheckTime'),
                array('collecttime','myCheckTime'),
                array('idgeral','numerical','integerOnly'=>true),
        );
    }
    public function myCheckTime($attribute,$params) {
        if(isset($this->{$attribute}))
        {
            //Get hours, minutes, seconds
            $time = explode(':', $this->{$attribute});
            
            if(!$this->hasErrors()) {
                if(! strtotime($this->{$attribute}) || $time[0] == "24" || $time[1] == "60" || $time[2] == "60") {
                    $this->addError($attribute,'The time is incorrect.');
                }

            }
        }
    }
    public function relations() {
        return array(
                //'specimen' => array(self::HAS_ONE, 'SpecimenAR', 'idmonitoring'),
                'geospatialelement' => array(self::BELONGS_TO, 'GeospatialElementAR', 'idgeospatialelement'),
                'localityelement' => array(self::BELONGS_TO, 'LocalityElementAR', 'idlocalityelement'),
                'taxonomicelement' => array(self::BELONGS_TO, 'TaxonomicElementAR', 'idtaxonomicelement'),
                'recordlevelelement' => array(self::BELONGS_TO, 'RecordLevelElementAR', 'idrecordlevelelement'),
                'occurrenceelement' => array(self::BELONGS_TO, 'OccurrenceElementAR', 'idoccurrenceelement'),
                'denomination' => array(self::BELONGS_TO, 'DenominationAR', 'iddenomination'),
                'technicalcollection' => array(self::BELONGS_TO, 'TechnicalCollectionAR', 'idtechnicalcollection'),
                'digitizer' => array(self::BELONGS_TO, 'DigitizerAR', 'iddigitizer'),
                'culture' => array(self::BELONGS_TO, 'CultureAR', 'idculture'),
                'cultivar' => array(self::BELONGS_TO, 'CultivarAR', 'idcultivar'),
                'predominantbiome' => array(self::BELONGS_TO, 'PredominantBiomeAR', 'idpredominantbiome'),
                'surroundingsculture' => array(self::BELONGS_TO, 'SurroundingsCultureAR', 'idsurroundingsculture'),
                'surroundingsvegetation' => array(self::BELONGS_TO, 'SurroundingsVegetationAR', 'idsurroundingsvegetation'),
                'colorpantrap' => array(self::BELONGS_TO, 'ColorPanTrapAR', 'idcolorpantrap'),
                'supporttype' => array(self::BELONGS_TO, 'SupportTypeAR', 'idsupporttype'),
                'collector' => array(self::BELONGS_TO, 'CollectorAR', 'idcollector'),
        		'groups' => array(self::BELONGS_TO, 'groups', 'idGroup'),
        );
    }
    public function attributeLabels() {
        return array(
                'idmonitoring' => 'Monitoring ID',
                'installationdate' => 'Installation date',
                'installationtime' => 'Installation time',
                'collectdate' => 'Collect date',
                'collecttime' => 'Collect time',
                'plotnumber' => 'Plot number',
                'amostralnumber' => 'Sample number',
                'floorheight' => 'Floor height',
                'weight' => 'Weight',
                'width' => 'Width',
                'length' => 'Length',
                'height' => 'Height',
                'iddenomination' => 'Denomination',
                'idtechnicalcollection' => 'Technical collection',
                'iddigitizer' => 'Digitizer',
                'idculture' => 'Culture',
                'idcultivar' => 'Cultivar',
                'idpredominantbiome' => 'Predominant biome',
                'idsurroundingsculture' => 'Surroundings culture',
                'idsurroundingsvegetation' => 'Surroundings vegetation',
                'idcolorpantrap' => 'Color pan trap A',
                'idsupporttype' => 'Support type',
                'idcollector' => 'Collector',
                'idgeral' => 'ID Geral'
        );
    }
}