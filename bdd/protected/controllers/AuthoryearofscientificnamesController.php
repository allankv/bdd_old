<?php

class AuthoryearofscientificnamesController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_authoryearofscientificnames;

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
	 * Shows a particular authoryearofscientificnames.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->renderPartial('show',array('authoryearofscientificnames'=>$this->loadauthoryearofscientificnames()));
	}

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
	
	/**
	 * Creates a new authoryearofscientificnames.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$authoryearofscientificnames=new authoryearofscientificnames;
		
		//se o campo foi preenchido
		if($_POST["authoryearofscientificname"]!="")
			$arrayValues =  array('authoryearofscientificname'=>$_POST["authoryearofscientificname"]);
			
		if(isset($arrayValues))
		{
			$authoryearofscientificnames->attributes=$arrayValues;
			if($authoryearofscientificnames->save())
			{
				echo $authoryearofscientificnames->authoryearofscientificname."|||".$authoryearofscientificnames->idauthoryearofscientificname;
				exit();
			}						
	//			$this->redirect(array('show','id'=>$authoryearofscientificnames->idauthoryearofscientificname));
		}
		$this->renderPartial('create',array('authoryearofscientificnames'=>$authoryearofscientificnames));
	}

	/**
	 * Updates a particular authoryearofscientificnames.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$authoryearofscientificnames=$this->loadauthoryearofscientificnames();
		if(isset($_POST['authoryearofscientificnames']))
		{
			$authoryearofscientificnames->attributes=$_POST['authoryearofscientificnames'];
			if($authoryearofscientificnames->save())
				$this->redirect(array('show','id'=>$authoryearofscientificnames->idauthoryearofscientificname));
		}
		$this->render('update',array('authoryearofscientificnames'=>$authoryearofscientificnames));
	}

	/**
	 * Deletes a particular authoryearofscientificnames.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadauthoryearofscientificnames()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all authoryearofscientificnamess.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$criteria=new CDbCriteria;
		$criteria->order = "authoryearofscientificname";
/*
		$pages=new CPagination(authoryearofscientificnames::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);
*/
		$authoryearofscientificnamesList=authoryearofscientificnames::model()->findAll($criteria);
/*
		$this->renderPartial('list',array(
			'authoryearofscientificnamesList'=>$authoryearofscientificnamesList,
			'pages'=>$pages,
		));
*/
		$this->renderPartial('list',array(
			'authoryearofscientificnamesList'=>$authoryearofscientificnamesList			
		));
		
	}

	/**
	 * Manages all authoryearofscientificnamess.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(authoryearofscientificnames::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('authoryearofscientificnames');
		$sort->applyOrder($criteria);

		$authoryearofscientificnamesList=authoryearofscientificnames::model()->findAll($criteria);

		$this->render('admin',array(
			'authoryearofscientificnamesList'=>$authoryearofscientificnamesList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadauthoryearofscientificnames($id=null)
	{
		if($this->_authoryearofscientificnames===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_authoryearofscientificnames=authoryearofscientificnames::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_authoryearofscientificnames===null)
				throw new CHttpException(500,'The requested authoryearofscientificnames does not exist.');
		}
		return $this->_authoryearofscientificnames;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadauthoryearofscientificnames($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
