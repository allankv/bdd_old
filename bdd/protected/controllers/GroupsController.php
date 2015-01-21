<?php

class GroupsController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_groups;

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
	 * Shows a particular groups.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->render('show',array('groups'=>$this->loadgroups()));
	}

	/**
	 * Creates a new groups.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$groups=new groups;
		if(isset($_POST['groups']))
		{
			$groups->attributes=$_POST['groups'];
			if($groups->save())
				$this->redirect(array('show','id'=>$groups->idGroup));
		}
		$this->render('create',array('groups'=>$groups));
	}

	/**
	 * Updates a particular groups.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$groups=$this->loadgroups();
		if(isset($_POST['groups']))
		{
			$groups->attributes=$_POST['groups'];
			if($groups->save())
				$this->redirect(array('show','id'=>$groups->idGroup));
		}
		$this->render('update',array('groups'=>$groups));
	}

	/**
	 * Deletes a particular groups.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadgroups()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all groupss.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;

		$pages=new CPagination(groups::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$groupsList=groups::model()->findAll($criteria);

		$this->render('list',array(
			'groupsList'=>$groupsList,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all groupss.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(groups::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('groups');
		$sort->applyOrder($criteria);

		$groupsList=groups::model()->findAll($criteria);

		$this->render('admin',array(
			'groupsList'=>$groupsList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadgroups($id=null)
	{
		if($this->_groups===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_groups=groups::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_groups===null)
				throw new CHttpException(500,'The requested groups does not exist.');
		}
		return $this->_groups;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadgroups($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
