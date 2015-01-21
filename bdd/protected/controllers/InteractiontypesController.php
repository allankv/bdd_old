<?php

class InteractiontypesController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_interactiontypes;

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
	 * Shows a particular interactiontypes.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->render('show',array('interactiontypes'=>$this->loadinteractiontypes()));
	}

	/**
	 * Creates a new interactiontypes.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$interactiontypes=new interactiontypes;
		if(isset($_POST['interactiontypes']))
		{
			$interactiontypes->attributes=$_POST['interactiontypes'];
			if($interactiontypes->save())
				$this->redirect(array('show','id'=>$interactiontypes->idinteractiontype));
		}
		$this->render('create',array('interactiontypes'=>$interactiontypes));
	}

	/**
	 * Updates a particular interactiontypes.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$interactiontypes=$this->loadinteractiontypes();
		if(isset($_POST['interactiontypes']))
		{
			$interactiontypes->attributes=$_POST['interactiontypes'];
			if($interactiontypes->save())
				$this->redirect(array('show','id'=>$interactiontypes->idinteractiontype));
		}
		$this->render('update',array('interactiontypes'=>$interactiontypes));
	}

	/**
	 * Deletes a particular interactiontypes.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadinteractiontypes()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all interactiontypess.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;

		$pages=new CPagination(interactiontypes::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$interactiontypesList=interactiontypes::model()->findAll($criteria);

		$this->render('list',array(
			'interactiontypesList'=>$interactiontypesList,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all interactiontypess.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(interactiontypes::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('interactiontypes');
		$sort->applyOrder($criteria);

		$interactiontypesList=interactiontypes::model()->findAll($criteria);

		$this->render('admin',array(
			'interactiontypesList'=>$interactiontypesList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadinteractiontypes($id=null)
	{
		if($this->_interactiontypes===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_interactiontypes=interactiontypes::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_interactiontypes===null)
				throw new CHttpException(500,'The requested interactiontypes does not exist.');
		}
		return $this->_interactiontypes;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadinteractiontypes($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
