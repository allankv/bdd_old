<?php

class SubcategoryreferencesController extends CController {
    const PAGE_SIZE=10;

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction='list';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_subcategoryreferences;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
                'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        //Metodo localizado dentro da classe WebbeeController em protected/components/
        return array(
            array('allow',
                'actions'=>array('create', 'edit', 'list'),
                'users'=>array('?'),
            ),

        );

    }

    /**
     * Shows a particular provider.
     */
    public function actionShow() {
        Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        $this->renderPartial('show',array('subcategoryreferences'=>$this->loadsubcategoryreferences()));
    }

    /*
	 * Controller method for set language session parameter
    */
    public function actionSiteLanguage() {
        $this->render('sitelanguage');
    }

    /**
     * Creates a new provider.
     * If creation is successful, the browser will be redirected to the 'show' page.
     */
    public function actionCreate() {
        Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        $subcategoryreferences=new subcategoryreferences;

        //verifica se o campo foi preenchido
        if($_POST["subcategoryreferences"]!="")
            $arrayValues =  array('subcategoryreferences'=>$_POST["subcategoryreferences"]);

        if(isset($arrayValues)) {
            $subcategoryreferences->attributes=$arrayValues;
            if($subcategoryreferences->save()) {
                echo $subcategoryreferences->subcategoryreferences."|||".$subcategoryreferences->idsubcategoryreferences;
                exit();
            }
            //$this->redirect(array('show','id'=>$provider->idprovider));
        }
        $this->renderPartial('create',array('subcategoryreferences'=>$subcategoryreferences));
    }

    /**
     * Updates a particular provider.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate() {
        Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        $subcategoryreferences=$this->loadsubcategoryreferences();
        if(isset($_POST['subcategoryreferences'])) {
            $subcategoryreferences->attributes=$_POST['subcategoryreferences'];
            if($subcategoryreferences->save())
                $this->redirect(array('show','id'=>$subcategoryreferences->idsubcategoryreferences));
        }
        $this->renderPartial('update',array('subcategoryreferences'=>$subcategoryreferences));
    }

    /**
     * Deletes a particular provider.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     */
    public function actionDelete() {
        if(Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadsubcategoryreferences()->delete();
            $this->redirect(array('list'));
        }
        else
            throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all provider.
     */
    public function actionList() {
        Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        $criteria=new CDbCriteria;
        $criteria->order = "subcategoryreferences";

        $pages=new CPagination(subcategoryreferences::model()->count($criteria));
        $pages->pageSize=self::PAGE_SIZE;
        $pages->applyLimit($criteria);

        $subcategoryreferencesList=subcategoryreferences::model()->findAll($criteria);

        $this->renderPartial('list',array(
                'subcategoryreferencesList'=>$subcategoryreferencesList,
                'pages'=>$pages,
        ));
    }

    /**
     * Manages all provider.
     */
    public function actionAdmin() {
        Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        $this->processAdminCommand();

        $criteria=new CDbCriteria;

        $pages=new CPagination(subcategoryreferences::model()->count($criteria));
        $pages->pageSize=self::PAGE_SIZE;
        $pages->applyLimit($criteria);

        $sort=new CSort('subcategoryreferences');
        $sort->applyOrder($criteria);

        $subcategoryreferencesList=subcategoryreferences::model()->findAll($criteria);

        $this->render('admin',array(
                'subcategoryreferencesList'=>$subcategoryreferencesList,
                'pages'=>$pages,
                'sort'=>$sort,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadsubcategoryreferences($id=null) {
        if($this->_subcategoryreferences===null) {
            if($id!==null || isset($_GET['id']))
                $this->_subcategoryreferences=subcategoryreferences::model()->findbyPk($id!==null ? $id : $_GET['id']);
            if($this->_subcategoryreferences===null)
                throw new CHttpException(500,'The requested subcategoryreferences does not exist.');
        }
        return $this->_subcategoryreferences;
    }

    /**
     * Executes any command triggered on the admin page.
     */
    protected function processAdminCommand() {
        if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete') {
            $this->loadsubcategoryreferences($_POST['id'])->delete();
            // reload the current page to avoid duplicated delete actions
            $this->refresh();
        }
    }
}
