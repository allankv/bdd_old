<?php

class ValiddistributionflagsController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_validdistributionflags;

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
	 * Shows a particular validdistributionflags.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		$this->renderPartial('show',array('validdistributionflags'=>$this->loadvaliddistributionflags()));
	}

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
	
	/**
	 * Creates a new validdistributionflags.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$validdistributionflags=new validdistributionflags;
		
		//verifica se o campo foi preenchido
		if($_POST["validdistributionflag"]!="")
			$arrayValues =  array('validdistributionflag'=>$_POST["validdistributionflag"]);
			
		if(isset($arrayValues))
		{
			$validdistributionflags->attributes=$arrayValues;
			if($validdistributionflags->save())
			{
				echo $validdistributionflags->validdistributionflag."|||".$validdistributionflags->idvaliddistributionflag;
				exit();				
			}
				//$this->redirect(array('show','id'=>$validdistributionflags->idvaliddistributionflag));
		}
		$this->renderPartial('create',array('validdistributionflags'=>$validdistributionflags));
	}

	/**
	 * Updates a particular validdistributionflags.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$validdistributionflags=$this->loadvaliddistributionflags();
		if(isset($_POST['validdistributionflags']))
		{
			$validdistributionflags->attributes=$_POST['validdistributionflags'];
			if($validdistributionflags->save())
				$this->redirect(array('show','id'=>$validdistributionflags->idvaliddistributionflag));
		}
		$this->renderPartial('update',array('validdistributionflags'=>$validdistributionflags));
	}

	/**
	 * Deletes a particular validdistributionflags.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadvaliddistributionflags()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all validdistributionflagss.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;
		$criteria->order = "validdistributionflag";
/*
		$pages=new CPagination(validdistributionflags::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);
*/
		$validdistributionflagsList=validdistributionflags::model()->findAll($criteria);
/*
		$this->renderPartial('list',array(
			'validdistributionflagsList'=>$validdistributionflagsList,
			'pages'=>$pages,
		));
*/
		$this->renderPartial('list',array(
			'validdistributionflagsList'=>$validdistributionflagsList,		
		));		
	}

	/**
	 * Manages all validdistributionflagss.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(validdistributionflags::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('validdistributionflags');
		$sort->applyOrder($criteria);

		$validdistributionflagsList=validdistributionflags::model()->findAll($criteria);

		$this->render('admin',array(
			'validdistributionflagsList'=>$validdistributionflagsList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadvaliddistributionflags($id=null)
	{
		if($this->_validdistributionflags===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_validdistributionflags=validdistributionflags::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_validdistributionflags===null)
				throw new CHttpException(500,'The requested validdistributionflags does not exist.');
		}
		return $this->_validdistributionflags;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadvaliddistributionflags($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
