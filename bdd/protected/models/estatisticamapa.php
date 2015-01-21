<?php

class estatisticamapa extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'estatisticamapa':
	 * @var integer $idrecordlevelelements
	 * @var string $institutioncode
	 * @var string $collectioncode
	 * @var string $catalognumber
	 * @var double $decimallatitude
	 * @var double $decimallongitude
	 * @var string $scientificname
	 * @var string $higherclassification
	 * @var integer $idbasisofrecord
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
		return 'estatisticamapa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('catalognumber','length','max'=>256),
			array('idrecordlevelelements, idbasisofrecord', 'numerical', 'integerOnly'=>true),
			array('decimallatitude, decimallongitude', 'numerical'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idrecordlevelelements' => 'Idrecordlevelelements',
			'institutioncode' => 'Institutioncode',
			'collectioncode' => 'Collectioncode',
			'catalognumber' => 'Catalognumber',
			'decimallatitude' => 'Decimallatitude',
			'decimallongitude' => 'Decimallongitude',
			'scientificname' => 'Scientificname',
			'higherclassification' => 'Higherclassification',
			'idbasisofrecord' => 'Idbasisofrecord',
		);
	}
}