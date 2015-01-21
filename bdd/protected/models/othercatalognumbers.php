<?php

class othercatalognumbers extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'othercatalognumbers':
	 * @var integer $idothercatalognumbers
	 * @var string $othercatalognumbers
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
		return 'othercatalognumbers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('othercatalognumbers','length','max'=>60),
			array('othercatalognumbers', 'required'),
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
			'curatorialelements' => array(self::MANY_MANY, 'Curatorialelements', 'othercatalognumberscuratorialelements(idothercatalognumbers, idcuratorialelements)'),
			'occurrenceelements' => array(self::MANY_MANY, 'Occurrenceelements', 'othercatalognumbersoccurrence(idoccurrenceelements, idothercatalognumbers)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idothercatalognumbers' => 'Idothercatalognumbers',
			'othercatalognumbers' => 'Othercatalognumbers',
		);
	}
}