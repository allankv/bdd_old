<?php

class mediarecordlevel extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'mediarecordlevel':
	 * @var integer $idmedia
	 * @var integer $idrecordlevelelements
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
		return 'mediarecordlevel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
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
                    'mediamr' => array(self::BELONGS_TO, 'media', 'idmedia'),
                    'recordlevelmr' => array(self::BELONGS_TO, 'recordlevelelements', 'idrecordlevelelements'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idmedia' => 'Idmedia',
			'idrecordlevelelements' => 'Idrecordlevelelements',
		);
	}
}