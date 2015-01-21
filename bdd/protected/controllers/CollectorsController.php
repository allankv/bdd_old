<?php

class CollectorsController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_collectors;

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
	 * Shows a particular collectors.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->renderPartial('show',array('collectors'=>$this->loadcollectors()));
	}

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
	
	/**
	 * Creates a new collectors.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$collectors=new collectors;
				
		//verifica se o campo foi preenchido
		if($_POST["collector"]!="")
			$arrayValues =  array('collector'=>$_POST["collector"]);
			
		if(isset($arrayValues))
		{
			$collectors->attributes=$arrayValues;
			if($collectors->save())
			{
				echo $collectors->collector."|||".$collectors->idcollector;
				exit();					
			}
				//$this->redirect(array('show','id'=>$collectors->idcollector));
		}
		$this->renderPartial('create',array('collectors'=>$collectors));
	}

	/**
	 * Updates a particular collectors.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$collectors=$this->loadcollectors();
		if(isset($_POST['collectors']))
		{
			$collectors->attributes=$_POST['collectors'];
			if($collectors->save())
				$this->redirect(array('show','id'=>$collectors->idcollector));
		}
		$this->renderPartial('update',array('collectors'=>$collectors));
	}

	/**
	 * Deletes a particular collectors.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadcollectors()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all collectorss.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;
		$criteria->order = "collector";
/*
		$pages=new CPagination(collectors::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);
*/
		$collectorsList=collectors::model()->findAll($criteria);
/*
		$this->renderPartial('list',array(
			'collectorsList'=>$collectorsList,
			'pages'=>$pages,
		));
*/
		
		$this->renderPartial('list',array(
			'collectorsList'=>$collectorsList,			
		));		
	}

	/**
	 * Manages all collectorss.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(collectors::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('collectors');
		$sort->applyOrder($criteria);

		$collectorsList=collectors::model()->findAll($criteria);

		$this->render('admin',array(
			'collectorsList'=>$collectorsList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadcollectors($id=null)
	{
		if($this->_collectors===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_collectors=collectors::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_collectors===null)
				throw new CHttpException(500,'The requested collectors does not exist.');
		}
		return $this->_collectors;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadcollectors($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
