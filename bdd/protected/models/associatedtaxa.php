<?php

class associatedtaxa extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'associatedtaxa':
	 * @var integer $idoccurrenceelements
	 * @var integer $idtaxonomicelements
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
		return 'associatedtaxa';
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idoccurrenceelements' => 'Idoccurrenceelements',
			'idtaxonomicelements' => 'Idtaxonomicelements',
		);
	}
}