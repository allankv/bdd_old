<?php

class ScientificnamesController extends CController
{
	const PAGE_SIZE=30;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_scientificnames;

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
	 * Shows a particular scientificnames.
	 */
	public function actionShow()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		$this->render('show',array('scientificnames'=>$this->loadscientificnames()));
	}

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
	
	/**
	 * Creates a new scientificnames.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$scientificnames=new scientificnames;
		
		//se o campo foi preenchido
		if($_POST["scientificname"]!="")
			$arrayValues =  array('scientificname'=>$_POST["scientificname"]);
			
		if(isset($arrayValues))
		{
			$scientificnames->attributes=$arrayValues;
			if($scientificnames->save())
			{
				echo $scientificnames->scientificname."|||".$scientificnames->idscientificname;
				exit();
			}			
			//	$this->redirect(array('show','id'=>$scientificnames->idscientificname));
		}
		$this->renderPartial('create',array('scientificnames'=>$scientificnames));
	}

	/**
	 * Updates a particular scientificnames.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$scientificnames=$this->loadscientificnames();
		if(isset($_POST['scientificnames']))
		{
			$scientificnames->attributes=$_POST['scientificnames'];
			if($scientificnames->save())
				$this->redirect(array('show','id'=>$scientificnames->idscientificname));
		}
		$this->render('update',array('scientificnames'=>$scientificnames));
	}

	/**
	 * Deletes a particular scientificnames.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{		
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadscientificnames()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all scientificnamess.
	 */
	public function actionList()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

		if ($_GET["filtrar"]<>"no"){                        
			$_formIdKingdom = $_GET["formIdKingdom"];
			$_formIdPhylum = $_GET["formIdPhylum"];
			$_formIdClass = $_GET["formIdClass"];
			$_formIdOrder = $_GET["formIdOrder"];
			$_formIdFamily = $_GET["formIdFamily"];
			$_formIdGenus = $_GET["formIdGenus"];
			$_formIdSubGenus = $_GET["formIdSubgenus"];
			$_formIdSpecificEpithet = $_GET["formIdSpecificEpithet"];
			$_formIdInfraSpecificEpithet = $_GET["formIdInfraSpecificEpithet"];
			$_formIdScientificName = $_GET["formIdScientificName"];

			$sqlFields = " FROM taxonomicelements WHERE 1=1 ";
			//Undefined returns from javascript when field doesn't exist. Look Recordlevel elements list.
			if($_formIdKingdom<>"" && $_formIdKingdom<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idkingdom = ".$_formIdKingdom." ";
                        }
	
			if($_formIdPhylum<>"" && $_formIdPhylum<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idphylum = ".$_formIdPhylum." ";
                        }
	
			if($_formIdClass<>"" && $_formIdClass<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idclass = ".$_formIdClass." ";
                        }
				
			if($_formIdOrder<>"" && $_formIdOrder<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idorder = ".$_formIdOrder." ";
                        }
	
			if($_formIdFamily<>"" && $_formIdFamily<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idfamily = ".$_formIdFamily." ";
                        }
	
			if($_formIdGenus<>"" && $_formIdGenus<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idgenus = ".$_formIdGenus." ";
                        }
                        
			if($_formIdSubGenus<>"" && $_formIdSubGenus<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idsubgenus = ".$_formIdSubGenus." ";
			}                        
	
			if($_formIdSpecificEpithet<>"" && $_formIdSpecificEpithet<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idspecificepithet = ".$_formIdSpecificEpithet." ";
                        }
	
			if($_formIdInfraSpecificEpithet<>"" && $_formIdInfraSpecificEpithet<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idinfraspecificepithets = ".$_formIdInfraSpecificEpithets." ";
                        }
	
			if($_formIdScientificName<>"" && $_formIdScientificName<>"undefined") {
				$sqlFields .= " AND taxonomicelements.idscientificname = ".$_formIdScientificName." ";
                        }
						
	
			$sqlComm = "SELECT DISTINCT  idscientificname, scientificname 
						FROM scientificnames WHERE 'this'='this' ";
	
			if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClass<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
				$sqlComm .=	" AND idscientificname IN (SELECT idscientificname ".$sqlFields."  )";
				

			$sqlComm .=	" ORDER By scientificname";
			

                        $sqlComm .= " LIMIT ".self::PAGE_SIZE;


			$scientificnamesList=scientificnames::model()->findAllBySql($sqlComm);

		}else{

                        $criteria=new CDbCriteria;
                        $criteria->order = "scientificname";
			$scientificnamesList=scientificnames::model()->findAll($criteria);
                        $pages=new CPagination(scientificnames::model()->count($criteria));
                        $pages->pageSize=self::PAGE_SIZE;
                        $pages->applyLimit($criteria);
                        
                }

		$this->renderPartial('list',array(
			'scientificnamesList'=>$scientificnamesList,
                        'pages'=>$pages,
		));		
	}

	/**
	 * Lists all scientificnamess.
	 */
	public function actionListInteraction()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);	
	
		/*
		 * pega os valores dos campos de interacao
		 */
		
		$_formIdInstitutionCode = $_GET['idinstitutioncode'];
		
		$_formIdCollectionCode = $_GET['idcollectioncode'];
		
		$_formIdTaxonomicElements = $_GET['idtaxonomicelements'];
		

		/*
		 * monta a consulta sql dos nomes cientificos baseado no que foi preenchido nos campos de interacao
		 */
		
		$sqlComm = "SELECT scientificname, idscientificname 
					FROM scientificnames ";
		
		if(($_formIdInstitutionCode<>"")||($_formIdCollectionCode<>"")||($_formIdTaxonomicElements<>"")){
			
			$sqlComm .= " WHERE idscientificname IN (
							SELECT idscientificname 
							FROM recordlevelelements
							WHERE 'this' = 'this'  ";

			if($_formIdInstitutionCode<>"")
				$sqlComm .= " AND idinstitutioncode = ".$_formIdInstitutionCode." ";
				
			if($_formIdCollectionCode<>"")
				$sqlComm .= " AND idcollectioncode = ".$_formIdCollectionCode." ";
	
			if($_formIdTaxonomicElements<>"")
				$sqlComm .= " AND idtaxonomicelements = ".$_formIdTaxonomicElements." ";
				
		
			$sqlComm .= " ) ";
		}

		$sqlComm .= " ORDER BY scientificname ";	
		
		echo $sqlComm;
		
		
		/*
		 * efetua a consulta
		 */
		
		$scientificnamesList=scientificnames::model()->findAllBySql($sqlComm);
		
		/*
		 * exibe a view com os dados
		 */
		
		$this->renderPartial('listInteraction',array(
			'scientificnamesList'=>$scientificnamesList			
		));		
	}	
	
	/**
	 * Manages all scientificnamess.
	 */
	public function actionAdmin()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(scientificnames::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('scientificnames');
		$sort->applyOrder($criteria);

		$scientificnamesList=scientificnames::model()->findAll($criteria);

		$this->render('admin',array(
			'scientificnamesList'=>$scientificnamesList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadscientificnames($id=null)
	{
		if($this->_scientificnames===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_scientificnames=scientificnames::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_scientificnames===null)
				throw new CHttpException(500,'The requested scientificnames does not exist.');
		}
		return $this->_scientificnames;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadscientificnames($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
