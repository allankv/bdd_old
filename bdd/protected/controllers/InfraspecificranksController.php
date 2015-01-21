<?php

class InfraspecificranksController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_infraspecificranks;

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
	 * Shows a particular infraspecificranks.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->render('show',array('infraspecificranks'=>$this->loadinfraspecificranks()));
	}

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
	
	/**
	 * Creates a new infraspecificranks.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$infraspecificranks=new infraspecificranks;
		
		
		//se o campo foi preenchido
		if($_POST["infraspecificrank"]!="")
			$arrayValues =  array('infraspecificrank'=>$_POST["infraspecificrank"]);
			
		if(isset($arrayValues))
		{
			$infraspecificranks->attributes=$arrayValues;
			if($infraspecificranks->save())
			{
				echo $infraspecificranks->infraspecificrank."|||".$infraspecificranks->idinfraspecificrank;
				exit();
			}			
			//	$this->redirect(array('show','id'=>$infraspecificranks->idinfraspecificrank));
		}
		$this->renderPartial('create',array('infraspecificranks'=>$infraspecificranks));
	}

	/**
	 * Updates a particular infraspecificranks.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$infraspecificranks=$this->loadinfraspecificranks();
		if(isset($_POST['infraspecificranks']))
		{
			$infraspecificranks->attributes=$_POST['infraspecificranks'];
			if($infraspecificranks->save())
				$this->redirect(array('show','id'=>$infraspecificranks->idinfraspecificrank));
		}
		$this->render('update',array('infraspecificranks'=>$infraspecificranks));
	}

	/**
	 * Deletes a particular infraspecificranks.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadinfraspecificranks()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all infraspecificrankss.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;
		$criteria->order = "infraspecificrank";
/*
		$pages=new CPagination(infraspecificranks::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);
*/
		$infraspecificranksList=infraspecificranks::model()->findAll($criteria);
/*
		$this->renderPartial('list',array(
			'infraspecificranksList'=>$infraspecificranksList,
			'pages'=>$pages,
		));
*/
		$this->renderPartial('list',array(
			'infraspecificranksList'=>$infraspecificranksList			
		));
		
	}

	/**
	 * Manages all infraspecificrankss.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(infraspecificranks::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('infraspecificranks');
		$sort->applyOrder($criteria);

		$infraspecificranksList=infraspecificranks::model()->findAll($criteria);

		$this->render('admin',array(
			'infraspecificranksList'=>$infraspecificranksList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadinfraspecificranks($id=null)
	{
		if($this->_infraspecificranks===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_infraspecificranks=infraspecificranks::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_infraspecificranks===null)
				throw new CHttpException(500,'The requested infraspecificranks does not exist.');
		}
		return $this->_infraspecificranks;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadinfraspecificranks($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
