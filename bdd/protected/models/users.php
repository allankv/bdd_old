<?php

class users extends CActiveRecord
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username','length','max'=>50),
			array('idGroup, username, password, email', 'required'),
			array('idGroup, idUserAdd', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'groups' => array(self::BELONGS_TO, 'groups', 'idGroup'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idUser'=>'Id User',
			'idGroup'=>'Id Group',
			'username'=>'Username',
			'password'=>'Password',
			'email'=>'Email', 
			'idUserAdd'=>'Id User Add',
			'dateValidated'=>'Date Validated',
		);
	}
}