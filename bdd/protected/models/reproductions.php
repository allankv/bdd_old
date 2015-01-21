<?php

class reproductions extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'reproductions':
	 * @var integer $idreproduction
	 * @var string $reproductions
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
		return 'reproductions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('reproductions','length','max'=>100),
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
			'specieelements' => array(self::HAS_MANY, 'Specieelements', 'reproductions_idreproduction'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idreproduction' => 'Idreproduction',
			'reproductions' => 'Reproductions',
		);
	}
}