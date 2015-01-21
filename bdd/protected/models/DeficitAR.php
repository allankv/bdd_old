<?php
class DeficitAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'deficit';
    }
    public function rules() {
        return array(
                array('year','numerical','integerOnly'=>true),
                array('recordingnumber','numerical','integerOnly'=>true),
                array('plotnumber','numerical','integerOnly'=>true),
                array('numberflowersobserved','numerical','integerOnly'=>true),
                array('apismellifera','numerical','integerOnly'=>true),
                array('bumblebees','numerical','integerOnly'=>true),
                array('otherbees','numerical','integerOnly'=>true),
                array('other','numerical','integerOnly'=>true),
   
                array('distancebetweenrows','numerical','integerOnly'=>false),
                array('distanceamongplantswithinrows','numerical','integerOnly'=>false),

                array('timeatstart','myCheckTime'),
                array('fieldnumber', 'required'),
                array('fieldnumber', 'unique'),
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
                'commonnamefocalcrop' => array(self::BELONGS_TO, 'CommonNameFocalCropAR', 'idcommonnamefocalcrop'),
                'localityelement' => array(self::BELONGS_TO, 'LocalityElementAR', 'idlocalityelement'),
                'geospatialelement' => array(self::BELONGS_TO, 'GeospatialElementAR', 'idgeospatialelement'),
                'typeholding' => array(self::BELONGS_TO, 'TypeHoldingAR', 'idtypeholding'),
                'topograficalsituation' => array(self::BELONGS_TO, 'TopograficalSituationAR', 'idtopograficalsituation'),
                'soiltype' => array(self::BELONGS_TO, 'SoilTypeAR', 'idsoiltype'),
                'soilpreparation' => array(self::BELONGS_TO, 'SoilPreparationAR', 'idsoilpreparation'),
                'mainplantspeciesinhedge' => array(self::BELONGS_TO, 'MainPlantSpeciesInHedgeAR', 'idmainplantspeciesinhedge'),
                'scientificname' => array(self::BELONGS_TO, 'ScientificNameAR', 'idscientificname'),
                'productionvariety' => array(self::BELONGS_TO, 'ProductionVarietyAR', 'idproductionvariety'),
                'originseeds' => array(self::BELONGS_TO, 'OriginSeedsAR', 'idoriginseeds'),
                'typeplanting' => array(self::BELONGS_TO, 'TypePlantingAR', 'idtypeplanting'),
                'typestand' => array(self::BELONGS_TO, 'TypeStandAR', 'idtypestand'),
                'focuscrop' => array(self::BELONGS_TO, 'FocusCropAR', 'idfocuscrop'),
                'treatment' => array(self::BELONGS_TO, 'TreatmentAR', 'idtreatment'),
                'observer' => array(self::BELONGS_TO, 'ObserverAR', 'idobserver'),
                'weathercondition' => array(self::BELONGS_TO, 'WeatherConditionAR', 'idweathercondition'),
        		'groups' => array(self::BELONGS_TO, 'groups', 'idGroup'),
        );
    }
    public function attributeLabels() {
        return array(
				'fieldnumber' => 'Field number',
				'year' => 'Year',
				'dimension' => 'Dimension',
				'fieldsize' => 'Field size',
				'hedgesurroundingfield' => 'Hedge surrounding the field',
				'distanceofnaturalhabitat' => 'Distance of natural habitat',
				'plantingdate' => 'Planting date',
				'plantdensity' => 'Plant density',
				'ratiopollenizertree' => 'Ratio pollinator tree',
				'distancebetweenrows' => 'Distance between rows',
				'distanceamongplantswithinrows' => 'Distance among plants within rows',
				'size' => 'Size',
				'date' => 'Date',
				'recordingnumber' => 'Recording number',
				'timeatstart' => 'Time at start',
				'period' => 'Period',
				'plotnumber' => 'Plot number',
				'numberflowersobserved' => 'Number of flowers observed',
				'apismellifera' => 'Apis mellifera',
				'bumblebees' => 'Bumblebees',
				'otherbees' => 'Other bees',
				'other' => 'Other',
				'remark' => 'Remark',
				'varietypollenizer' => 'Variety pollinator if present',
        );
    }
}