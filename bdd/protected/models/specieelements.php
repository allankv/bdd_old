<?php

class specieelements extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'specieelements':
	 * @var integer $idspecieelements
	 * @var integer $iddiseases
	 * @var integer $idlifeexpectancies
	 * @var integer $idreproduction
	 * @var integer $idmigration
	 * @var integer $idsynonyms
	 * @var integer $idcanonicalnames
	 * @var integer $idcommonnames
	 * @var integer $idlifecycles
	 * @var integer $iddispersal
	 * @var integer $idannualcycle
	 * @var integer $idhabitat
	 * @var integer $chromosomicnumbern
	 * @var integer $idtaxonomicelements
	 * @var string $modified
	 * @var string $datecreate
	 * @var string $growth
	 * @var string $molecularbiology
	 * @var string $genetics
	 * @var string $size
	 * @var string $populationbiology
	 * @var string $evolution
	 * @var string $description
	 * @var string $cytology
	 * @var integer $idbehavior
	 * @var string $verbatimlocality
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'specieelements';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('chromosomicnumbern', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idbehavior0' => array(self::BELONGS_TO, 'Behavior', 'idbehavior'),
			'idtaxonomicelements0' => array(self::BELONGS_TO, 'Taxonomicelements', 'idtaxonomicelements'),
			'idsynonyms0' => array(self::BELONGS_TO, 'Synonymis', 'idsynonyms'),
			'idreproduction0' => array(self::BELONGS_TO, 'Reproductions', 'idreproduction'),
			'idmigration0' => array(self::BELONGS_TO, 'Migrations', 'idmigration'),
			'idlifeexpectancies0' => array(self::BELONGS_TO, 'Lifeexpectancies', 'idlifeexpectancies'),
			'idlifecycles0' => array(self::BELONGS_TO, 'Lifecycles', 'idlifecycles'),
			'idhabitat0' => array(self::BELONGS_TO, 'Habitats', 'idhabitat'),
			'iddispersal0' => array(self::BELONGS_TO, 'Dispersals', 'iddispersal'),
			'iddiseases0' => array(self::BELONGS_TO, 'Diseases', 'iddiseases'),
			'idcommonnames0' => array(self::BELONGS_TO, 'Commonnames', 'idcommonnames'),
			'idcanonicalnames0' => array(self::BELONGS_TO, 'Canonicalnames', 'idcanonicalnames'),
			'idannualcycle0' => array(self::BELONGS_TO, 'Annualcycle', 'idannualcycle'),
			'referenceselements' => array(self::MANY_MANY, 'Referenceselements', 'referencesspecie(idreferenceselements, idspecieselements)'),
			'medias' => array(self::MANY_MANY, 'Media', 'mediaspecie(idspecieelements, idmedia)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idspecieelements' => 'Idspecieelements',
			'iddiseases' => 'Iddiseases',
			'idlifeexpectancies' => 'Idlifeexpectancies',
			'idreproduction' => 'Idreproduction',
			'idmigration' => 'Idmigration',
			'idsynonyms' => 'Idsynonyms',
			'idcanonicalnames' => 'Idcanonicalnames',
			'idcommonnames' => 'Idcommonnames',
			'idlifecycles' => 'Idlifecycles',
			'iddispersal' => 'Iddispersal',
			'idannualcycle' => 'Idannualcycle',
			'idhabitat' => 'Idhabitat',
			'chromosomicnumbern' => 'Chromosomicnumbern',
			'idtaxonomicelements' => 'Idtaxonomicelements',
			'modified' => 'Modified',
			'datecreate' => 'Datecreate',
			'growth' => 'Growth',
			'molecularbiology' => 'Molecularbiology',
			'genetics' => 'Genetics',
			'size' => 'Size',
			'populationbiology' => 'Populationbiology',
			'evolution' => 'Evolution',
			'description' => 'Description',
			'cytology' => 'Cytology',
			'idbehavior' => 'Idbehavior',
			'verbatimlocality' => 'Verbatimlocality',
		);
	}
}