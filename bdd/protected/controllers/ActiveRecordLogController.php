<?php

class ActiveRecordLogController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_activerecordlog;

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
	 * Shows a particular activerecordlog.
	 */
	public function actionShow()
	{
		$this->render('show',array('activerecordlog'=>$this->loadActiveRecordLog()));
	}

	/**
	 * Creates a new activerecordlog.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		$activerecordlog=new ActiveRecordLog;
		if(isset($_POST['ActiveRecordLog']))
		{
			$activerecordlog->attributes=$_POST['ActiveRecordLog'];
			if($activerecordlog->save())
				$this->redirect(array('show','id'=>$activerecordlog->id));
		}
		$this->render('create',array('activerecordlog'=>$activerecordlog));
	}

	/**
	 * Updates a particular activerecordlog.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		$activerecordlog=$this->loadActiveRecordLog();
		if(isset($_POST['ActiveRecordLog']))
		{
			$activerecordlog->attributes=$_POST['ActiveRecordLog'];
			if($activerecordlog->save())
				$this->redirect(array('show','id'=>$activerecordlog->id));
		}
		$this->render('update',array('activerecordlog'=>$activerecordlog));
	}

	/**
	 * Deletes a particular activerecordlog.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadActiveRecordLog()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all activerecordlogs.
	 */
	public function actionList()
	{
		$criteria=new CDbCriteria;

		$pages=new CPagination(ActiveRecordLog::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$activerecordlogList=ActiveRecordLog::model()->findAll($criteria);

		$this->render('list',array(
			'activerecordlogList'=>$activerecordlogList,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all activerecordlogs.
	 */
	public function actionAdmin()
	{
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(ActiveRecordLog::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('ActiveRecordLog');
		$sort->applyOrder($criteria);

		$activerecordlogList=ActiveRecordLog::model()->findAll($criteria);

		$this->render('admin',array(
			'activerecordlogList'=>$activerecordlogList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadActiveRecordLog($id=null)
	{
		if($this->_activerecordlog===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_activerecordlog=ActiveRecordLog::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_activerecordlog===null)
				throw new CHttpException(500,'The requested activerecordlog does not exist.');
		}
		return $this->_activerecordlog;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadActiveRecordLog($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
