<?php
class MediaAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'media';
    }
    public function rules() {
        return array(
                array('idcategorymedia', 'required','message'=>'The field Category is required.'),
                array('idtypemedia', 'required','message'=>'The field Type is required.'),
                array('title', 'required','message'=>'The field Title is required.'),
                array('caption','length','max'=>80),
                array('publishedsource','length','max'=>100),
                array('attributionlinkurl','length','max'=>100),
                array('attributionlogourl','length','max'=>100),
                array('attributionstatement','length','max'=>100),
                array('copyrightstatement','length','max'=>100),
                array('copyrightowner','length','max'=>100),
                array('title','length','max'=>512),
                array('accesspoint','length','max'=>100),
                array('accessurl','length','max'=>1000),
                array('extent','length','max'=>50),
                array('timedigitized','myCheckTime'),
                //array('scientificname', 'length', 'max'=>100),  //Necessario?
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
            'specimen' => array(self::MANY_MANY, 'SpecimenAR', 'specimenmedia(idspecimen, idmedia)'),
            'language' => array(self::BELONGS_TO, 'LanguageAR', 'idlanguage'),
            'provider' => array(self::BELONGS_TO, 'ProviderAR', 'idprovider'),
            'metadataprovider' => array(self::BELONGS_TO, 'MetadataProviderAR', 'idmetadataprovider'),
            'subtype' => array(self::BELONGS_TO, 'SubtypeAR', 'idsubtype'),
            'formatmedia' => array(self::BELONGS_TO, 'FormatMediaAR', 'idformatmedia'),
            'capturedevice' => array(self::BELONGS_TO, 'CaptureDeviceAR', 'idcapturedevice'),
            'localityelement' => array(self::BELONGS_TO, 'LocalityElementAR', 'idlocalityelement'),
            'typemedia' => array(self::BELONGS_TO, 'TypeMediaAR', 'idtypemedia'),
            'subcategorymedia' => array(self::BELONGS_TO, 'SubcategoryMediaAR', 'idsubcategorymedia'),
            'categorymedia' => array(self::BELONGS_TO, 'CategoryMediaAR', 'idcategorymedia'),
            'file' => array(self::BELONGS_TO, 'FileAR', 'idfile'),
            'fileformat' => array(self::BELONGS_TO, 'FileFormatAR', 'idfileformat'),
            'creator' => array(self::MANY_MANY, 'CreatorAR', 'mediacreator(idmedia, idcreator)'),
            'tag' => array(self::MANY_MANY, 'TagAR', 'mediatag(idmedia, idtag)'),
        	'groups' => array(self::BELONGS_TO, 'groups', 'idGroup'),

        );
    }
    public function attributeLabels() {
        return array(
                'idmedia' => 'Media ID',
                'caption' => 'Caption',
                'description' => 'Description',
                'publishedsource' => 'Published source',
                'attributionlinkurl' => 'Attribution link URL',
                'attributionlogourl' => 'Attribution logo URL',
                'attributionstatement' => 'Attribution statement',
                'copyrightstatement' => 'Copyright statement',
                'copyrightowner' => 'Copyright owner',
                'dateavailable' => 'Date available',
                'modified' => 'Modified',
                'comment' => 'Comments',
                'title' => 'Title',
                'datedigitized' => 'Date digitized',
                'timedigitized' => 'Time digitized',
                'accesspoint' => 'Access point',
                'accessurl' => 'Access URL',
                'extent' => 'Extent',
                'idlanguage' => 'Language ID',
                'idprovider' => 'Provider ID',
                'idmetadataprovider' => 'Metadata provider ID',
                'idsubtype' => 'Subtype ID',
                'idformatmedia' => 'Format ID',
                'idcapturedevice' => 'Capture device',
                'idlocalityelement' => 'Locality ID',
                'idtypemedia' => 'Type ID',
                'idsubcategorymedia' => 'Subcategory ID',
                'idcategorymedia' => 'Category ID',
                'idfile' => 'File ID',
                'idfileformat' => 'File format ID',
                'idcreator' => 'Creator ID',
                'scientificname' => 'Scientific name',

        );
    }
}