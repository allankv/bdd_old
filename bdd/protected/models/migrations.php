<?php

class migrations extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'migrations':
	 * @var integer $idmigration
	 * @var string $migration
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
		return 'migrations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('migration','length','max'=>255),
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
			'specieelements' => array(self::HAS_MANY, 'Specieelements', 'idmigration'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idmigration' => 'Idmigration',
			'migration' => 'Migration',
		);
	}
}