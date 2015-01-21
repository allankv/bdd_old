<?php

class subjectcategory extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'subjectcategory':
	 * @var integer $idsubjectcategory
	 * @var string $subjectcategory
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
		return 'subjectcategory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('subjectcategory','length','max'=>50),
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
			'medias' => array(self::MANY_MANY, 'Media', 'subjectcategorymedia(idsubjectcategory, idmedia)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idsubjectcategory' => 'Idsubjectcategory',
			'subjectcategory' => 'Subjectcategory',
		);
	}
}