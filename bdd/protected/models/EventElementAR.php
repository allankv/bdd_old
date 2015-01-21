<?php
class EventElementAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'eventelement';
    }
    public function rules() {
        return array(
                array('eventtime','myCheckTime'),
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
                'recordlevelelement' => array(self::HAS_MANY, 'RecordLevelElementAR', 'ideventelement'),
                'habitat' => array(self::BELONGS_TO, 'HabitatAR', 'idhabitat'),
                'samplingprotocol' => array(self::BELONGS_TO, 'SamplingProtocolAR', 'idsamplingprotocol'),
        );
    }
    public function attributeLabels() {
        return array(
                'ideventelement' => 'Event element ID',
                'idsamplingprotocol' => 'Sampling protocol ID',
                'samplingeffort' => 'Sampling effort',
                'eventdate' => 'Event date',
                'eventtime' => 'Event time',
                'verbatimeventdate' => 'Verbatim event date',
                'idhabitat' => 'Habitat ID',
                'fieldnumber' => 'Field number',
                'fieldnote' => 'Field notes',
                'eventremark' => 'Event remarks',
        );
    }
}