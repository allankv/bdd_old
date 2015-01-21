<?php

class BiologicalelementsController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_biologicalelements;

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
	 * Shows a particular biologicalelements.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->render('show',array('biologicalelements'=>$this->loadbiologicalelements()));
	}

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
	
	/**
	 * Creates a new biologicalelements.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$biologicalelements=new biologicalelements;
		if(isset($_POST['biologicalelements']))
		{
			$biologicalelements->attributes=$_POST['biologicalelements'];

			if($biologicalelements->save())
				$this->redirect(array('show','id'=>$biologicalelements->idbiologicalelements));
		}
		$this->render('create',array('biologicalelements'=>$biologicalelements));
	}

	/**
	 * Updates a particular biologicalelements.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$biologicalelements=$this->loadbiologicalelements();
		if(isset($_POST['biologicalelements']))
		{
			$biologicalelements->attributes=$_POST['biologicalelements'];
			if($biologicalelements->save())
				$this->redirect(array('show','id'=>$biologicalelements->idbiologicalelements));
		}
		$this->render('update',array('biologicalelements'=>$biologicalelements));
	}

	/**
	 * Deletes a particular biologicalelements.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadbiologicalelements()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all biologicalelementss.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;

		$pages=new CPagination(biologicalelements::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$biologicalelementsList=biologicalelements::model()->findAll($criteria);

		$this->render('list',array(
			'biologicalelementsList'=>$biologicalelementsList,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all biologicalelementss.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(biologicalelements::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('biologicalelements');
		$sort->applyOrder($criteria);

		$biologicalelementsList=biologicalelements::model()->findAll($criteria);

		$this->render('admin',array(
			'biologicalelementsList'=>$biologicalelementsList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadbiologicalelements($id=null)
	{
		if($this->_biologicalelements===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_biologicalelements=biologicalelements::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_biologicalelements===null)
				throw new CHttpException(500,'The requested biologicalelements does not exist.');
		}
		return $this->_biologicalelements;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadbiologicalelements($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
