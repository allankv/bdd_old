<?php

class highergeograph extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'highergeograph':
	 * @var integer $idhighergeograph
	 * @var string $highergeographid
	 * @var string $highergeograph
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
		return 'highergeograph';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('highergeographid','length','max'=>60),
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
			'localityelements' => array(self::HAS_MANY, 'Localityelements', 'idhighergeograph'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idhighergeograph' => 'Idhighergeograph',
			'highergeographid' => 'Highergeographid',
			'highergeograph' => 'Highergeograph',
		);
	}
}