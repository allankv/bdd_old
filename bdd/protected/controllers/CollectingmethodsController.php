<?php

class CollectingmethodsController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_collectingmethods;

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
	 * Shows a particular collectingmethods.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->renderPartial('show',array('collectingmethods'=>$this->loadcollectingmethods()));
	}

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
	
	/**
	 * Creates a new collectingmethods.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$collectingmethods=new collectingmethods;
		
		
		//verifica se o campo foi preenchido
		if($_POST["collectingmethod"]!="")
			$arrayValues =  array('collectingmethod'=>$_POST["collectingmethod"]);
			
		if(isset($arrayValues))
		{
			$collectingmethods->attributes=$arrayValues;
			if($collectingmethods->save())
			{
				echo $collectingmethods->collectingmethod."|||".$collectingmethods->idcollectingmethod;
				exit();					
			}
			//	$this->redirect(array('show','id'=>$collectingmethods->idcollectingmethod));
		}
		$this->renderPartial('create',array('collectingmethods'=>$collectingmethods));
	}

	/**
	 * Updates a particular collectingmethods.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$collectingmethods=$this->loadcollectingmethods();
		if(isset($_POST['collectingmethods']))
		{
			$collectingmethods->attributes=$_POST['collectingmethods'];
			if($collectingmethods->save())
				$this->redirect(array('show','id'=>$collectingmethods->idcollectingmethod));
		}
		$this->renderPartial('update',array('collectingmethods'=>$collectingmethods));
	}

	/**
	 * Deletes a particular collectingmethods.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadcollectingmethods()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all collectingmethodss.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;
		$criteria->order = "collectingmethod";
/*
		$pages=new CPagination(collectingmethods::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);
*/
		$collectingmethodsList=collectingmethods::model()->findAll($criteria);
/*
		$this->renderPartial('list',array(
			'collectingmethodsList'=>$collectingmethodsList,
			'pages'=>$pages,
		));
*/
		$this->renderPartial('list',array(
			'collectingmethodsList'=>$collectingmethodsList			
		));		
	}

	/**
	 * Manages all collectingmethodss.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(collectingmethods::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('collectingmethods');
		$sort->applyOrder($criteria);

		$collectingmethodsList=collectingmethods::model()->findAll($criteria);

		$this->renderPartial('admin',array(
			'collectingmethodsList'=>$collectingmethodsList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadcollectingmethods($id=null)
	{
		if($this->_collectingmethods===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_collectingmethods=collectingmethods::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_collectingmethods===null)
				throw new CHttpException(500,'The requested collectingmethods does not exist.');
		}
		return $this->_collectingmethods;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadcollectingmethods($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
