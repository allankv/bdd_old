<?php

class ProviderController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_provider;

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
	 * Shows a particular provider.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

		$this->renderPartial('show',array('provider'=>$this->loadprovider()));
	}

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}

	/**
	 * Creates a new provider.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

		$provider=new provider;

		//verifica se o campo foi preenchido
		if($_POST["provider"]!="")
			$arrayValues =  array('provider'=>$_POST["provider"]);

		if(isset($arrayValues))
		{
			$provider->attributes=$arrayValues;
			if($provider->save())
			{
				echo $provider->provider."|||".$provider->idprovider;
				exit();
		}
				//$this->redirect(array('show','id'=>$provider->idprovider));
	}
		$this->renderPartial('create',array('provider'=>$provider));
	}

	/**
	 * Updates a particular provider.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

		$provider=$this->loadprovider();
		if(isset($_POST['provider']))
		{
			$provider->attributes=$_POST['provider'];
			if($provider->save())
				$this->redirect(array('show','id'=>$provider->idprovider));
		}
		$this->renderPartial('update',array('provider'=>$provider));
	}

	/**
	 * Deletes a particular provider.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadprovider()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all provider.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

		$criteria=new CDbCriteria;
		$criteria->order = "provider";

		$pages=new CPagination(provider::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$providerList=provider::model()->findAll($criteria);

		$this->renderPartial('list',array(
			'providerList'=>$providerList,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all provider.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(provider::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('provider');
		$sort->applyOrder($criteria);

		$providerList=provider::model()->findAll($criteria);

		$this->render('admin',array(
			'providerList'=>$providerList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadprovider($id=null)
	{
		if($this->_provider===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_provider=provider::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_provider===null)
				throw new CHttpException(500,'The requested provider does not exist.');
		}
		return $this->_provider;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadprovider($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
