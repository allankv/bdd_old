<?php

class AttributesController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_attributes;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		//Metodo localizado dentro da classe WebbeeController em protected/components/
		return WebbeeController::controlAccess();
	}

	/**
	 * Shows a particular attributes.
	 */
	public function actionShow()
	{
		$this->render('show',array('attributes'=>$this->loadattributes()));
	}

	/**
	 * Creates a new attributes.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$attributes=new attributes;
		if(isset($_POST['attributes']))
		{
			$attributes->attributes=$_POST['attributes'];
			if($attributes->save())
				$this->redirect(array('show','id'=>$attributes->idAttribute));
		}
		$this->render('create',array('attributes'=>$attributes));
	}

	/**
	 * Updates a particular attributes.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$attributes=$this->loadattributes();
		if(isset($_POST['attributes']))
		{
			$attributes->attributes=$_POST['attributes'];
			if($attributes->save())
				$this->redirect(array('show','id'=>$attributes->idAttribute));
		}
		$this->render('update',array('attributes'=>$attributes));
	}

	/**
	 * Deletes a particular attributes.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadattributes()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all attributess.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;

		$pages=new CPagination(attributes::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$attributesList=attributes::model()->findAll($criteria);

		$this->render('list',array(
			'attributesList'=>$attributesList,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all attributess.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(attributes::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('attributes');
		$sort->applyOrder($criteria);

		$attributesList=attributes::model()->findAll($criteria);

		$this->render('admin',array(
			'attributesList'=>$attributesList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadattributes($id=null)
	{
		if($this->_attributes===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_attributes=attributes::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_attributes===null)
				throw new CHttpException(500,'The requested attributes does not exist.');
		}
		return $this->_attributes;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadattributes($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
