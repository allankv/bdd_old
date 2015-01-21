<?php

class UsersController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_users;

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
		return WebbeeController::controlAccess();
	}

	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
	
	/**
	 * Shows a particular users.
	 */
	public function actionShow()
	{
		//Set session language variable
		$sitelanguage =new MultiLanguage;
		$sitelanguage->getSiteLanguage();
		
		$idUser = Yii::app()->user->id;			
		
		$attributeAdmin = WebbeeController::executaSQL(
			"SELECT idGroup FROM users U WHERE U.idUser = ". $idUser);
        
		// Se pertece ao grupo de administradores OU se est� querendo acessar o show do seu próprio usuário
		// Carrega o show		
		if ($this->loadusers()->idUser == $idUser || WebbeeController::procuraEmArray($attributeAdmin, '1')) {
			$this->render('show',array('users'=>$this->loadusers()));	 
		}
		//senão carrega p�gina de alerta
		else $this->render('semPermissao');
		
	}

	/**
	 * Creates a new users.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		//Set session language variable
		$sitelanguage =new MultiLanguage;
		$sitelanguage->getSiteLanguage();
		
		$users=new users;
		if(isset($_POST['users']))
		{
			$users->attributes=$_POST['users'];
			$users->setAttribute('password', md5($users->getAttribute('password')));
			if($users->save())
				$this->redirect(array('show','id'=>$users->idUser));
		}
		$this->render('create',array('users'=>$users));
	}

	/**
	 * Updates a particular users.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		//Set session language variable
		$sitelanguage =new MultiLanguage;
		$sitelanguage->getSiteLanguage();
		
		$users=$this->loadusers();
		// Entra aqui só se for uma ação de UPDATE de fato (após clicar no botão "Save")
		if(isset($_POST['users']))
		{
			$users->attributes=$_POST['users'];
						
			if (strlen($users->password) == 0) {
				$users->setAttribute('password', $_POST['oldPassword']);						
			}
			else {
				$users->setAttribute('password', md5($users->getAttribute('password')));				
			}
						
			if($users->save())
				$this->redirect(array('show','id'=>$users->idUser));
				
		}
		
		
		// Chega aqui se estiver apenas abrindo a página update
		
		$idUser = Yii::app()->user->id;		
		
		$attributeAdmin = WebbeeController::executaSQL(
			"SELECT idGroup FROM users U WHERE U.idUser = ". $idUser);		  
		
		// Se pertece ao grupo de administradores OU se está querendo acessar o update do seu próprio usuário
		// Carrega o update		
		if ($users->idUser == $idUser || WebbeeController::procuraEmArray($attributeAdmin, '1')) {
			$this->render('update',array('users'=>$users));	 
		}
		//senão carrega página de alerta
		else $this->render('semPermissao');		
		
	}

	/**
	 * Deletes a particular users.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadusers()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all userss.
	 */
	public function actionList()
	{
		//Set session language variable
		$sitelanguage =new MultiLanguage;
		$sitelanguage->getSiteLanguage();
		
		$criteria=new CDbCriteria;

		$pages=new CPagination(users::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$usersList=users::model()->findAll($criteria);

		$this->render('list',array(
			'usersList'=>$usersList,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all userss.
	 */
	public function actionAdmin()
	{
		
		//Set session language variable
		$sitelanguage =new MultiLanguage;
		$sitelanguage->getSiteLanguage();
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(users::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('users');
		$sort->applyOrder($criteria);

		$usersList=users::model()->findAll($criteria);

		$this->render('admin',array(
			'usersList'=>$usersList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadusers($id=null)
	{
		if($this->_users===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_users=users::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_users===null)
				throw new CHttpException(500,'The requested users does not exist.');
		}
		return $this->_users;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadusers($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();			
		}
	}
}
