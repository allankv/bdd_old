<?php

class CollectingeventelementsController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_collectingeventelements;

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
	 * Shows a particular collectingeventelements.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->render('show',array('collectingeventelements'=>$this->loadcollectingeventelements()));
	}

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
	
	/**
	 * Creates a new collectingeventelements.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$collectingeventelements=new collectingeventelements;
		if(isset($_POST['collectingeventelements']))
		{
			$collectingeventelements->attributes=$_POST['collectingeventelements'];
			if($collectingeventelements->save())
				$this->redirect(array('show','id'=>$collectingeventelements->idcollectingeventelements));
		}
		$this->render('create',array('collectingeventelements'=>$collectingeventelements));
	}

	/**
	 * Updates a particular collectingeventelements.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$collectingeventelements=$this->loadcollectingeventelements();
		if(isset($_POST['collectingeventelements']))
		{
			$collectingeventelements->attributes=$_POST['collectingeventelements'];
			if($collectingeventelements->save())
				$this->redirect(array('show','id'=>$collectingeventelements->idcollectingeventelements));
		}
		$this->render('update',array('collectingeventelements'=>$collectingeventelements));
	}

	/**
	 * Deletes a particular collectingeventelements.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadcollectingeventelements()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all collectingeventelementss.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;

		$pages=new CPagination(collectingeventelements::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$collectingeventelementsList=collectingeventelements::model()->findAll($criteria);

		$this->render('list',array(
			'collectingeventelementsList'=>$collectingeventelementsList,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all collectingeventelementss.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(collectingeventelements::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('collectingeventelements');
		$sort->applyOrder($criteria);

		$collectingeventelementsList=collectingeventelements::model()->findAll($criteria);

		$this->render('admin',array(
			'collectingeventelementsList'=>$collectingeventelementsList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadcollectingeventelements($id=null)
	{
		if($this->_collectingeventelements===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_collectingeventelements=collectingeventelements::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_collectingeventelements===null)
				throw new CHttpException(500,'The requested collectingeventelements does not exist.');
		}
		return $this->_collectingeventelements;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadcollectingeventelements($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
