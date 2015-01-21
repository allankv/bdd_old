<?php

class groups extends CActiveRecord
{
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
		return 'groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('group', 'required'),
			array('group', 'unique'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'users' => array(self::HAS_MANY, 'users', 'idGroup'),
			'media' => array(self::HAS_MANY, 'MediaAR', 'idgroup'),
			'referenceelement' => array(self::HAS_MANY, 'ReferenceAR', 'idgroup'),
			'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idgroup'),
			'species' => array(self::HAS_MANY, 'SpeciesAR', 'idgroup'),
			'interaction' => array(self::HAS_MANY, 'InteractionAR', 'idgroup'),
			'specimen' => array(self::HAS_MANY, 'SpecimenAR', 'idgroup'),
			'log' => array(self::HAS_MANY, 'LogAR', 'idgroup'),
			'morphospecies' => array(self::HAS_MANY, 'MorphospeciesAR', 'idgroup'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		);
	}
	
	/*
	 * Método que registra log no banco
	 */
	public function behaviors()
	{
	    return array(
	        // Classname => path to Class
	        'ActiveRecordLogableBehavior'=>
	            'application.behaviors.ActiveRecordLogableBehavior',
    	);
	}
}