<?php

class lifecycles extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'lifecycles':
	 * @var integer $idlifecycles
	 * @var string $lifecycle
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
		return 'lifecycles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('lifecycle','length','max'=>50),
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
			'specieelements' => array(self::HAS_MANY, 'Specieelements', 'idlifecycles'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idlifecycles' => 'Idlifecycles',
			'lifecycle' => 'Lifecycle',
		);
	}
}