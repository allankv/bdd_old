<?php

class ReferenceselementsController extends CController {
    const PAGE_SIZE=10;

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction='list';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

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
        return WebbeeController::controlAccess();
    }

    /**
     * Shows a particular model.
     */
    public function actionShow() {
        $this->render('show',array('referenceselements'=>$this->loadreferenceselements()));
    }

    /*
	 * Controller method for set language session parameter
    */
    public function actionSiteLanguage() {
        $this->render('sitelanguage');
    }
    
    
    /*
     * 	Realiza a associação entre um registro de arquivo e referencia  
     */
    
    public function actionAssociacaoReferenceFile(){
    
    	$idFile = $_GET["idFile"];
    	$idReference = $_GET["idReference"];
    	
    	if(($idFile!="")&&($idFile!=0)&&($idReference!="")){
    	
    		$reference = $this->loadreferenceselements($idReference);
    		$reference->idfile = $idFile;

    		if($reference->save()){
    		
    			echo "OK";
    		
    		}
    	
    	}   	
    
    }
    
    /*
     * 	Realiza a desassociação entre um registro de arquivo e referencia  
     */
    
    public function actionDesassociacaoReferenceFile(){
    
    	$idReference = $_GET["idReference"];
    	$msgErro = "";
    	
    	if($idReference!=""){
    	
    		$reference = $this->loadreferenceselements($idReference);
    		$idFile = $reference->idfile;
    		
    		$reference->idfile = null;

    		if($reference->update()){
    			
    			Yii::import('application.controllers.FilesController');

    			$filesController = new FilesController("Files");
    		
    			$msgErro = $filesController->formDelete($idFile);
    			
    			if ($msgErro==""){
    			
    				echo "OK";
    				
    			}
    		
    		}
    	
    	}   	
    
    }    


    public function actionRelationship() {
        if(Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            if($_GET['type']=='add') {
                $referencerecordlevel = referencerecordlevel::model();
                $referencerecordlevel->idreferenceselements = $_GET['idreference'];
                $referencerecordlevel->idrecordlevelelements = $_GET['idrecordlevel'];
                $referencerecordlevel->setIsNewRecord(true);
                $referencerecordlevel->save();
                echo 'Relationship between Reference "'.referenceselements::model()->findByPk($_GET['idreference'])->title.'" and Specimen "'.
                        recordlevelelements::model()->findByPk($_GET['idrecordlevel'])->globaluniqueidentifier.'" added correctly';
            }else {
                $referencerecordlevel = referencerecordlevel::model();
                $referencerecordlevel->idreferenceselements = $_GET['idreference'];
                $referencerecordlevel->idrecordlevelelements = $_GET['idrecordlevel'];
                $referencerecordlevel->delete();
                echo 'Relationship between Reference "'.referenceselements::model()->findByPk($_GET['idreference'])->title.'" and Specimen "'.
                        recordlevelelements::model()->findByPk($_GET['idrecordlevel'])->globaluniqueidentifier.'" removed correctly';
            }
        }
        else
            throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'show' page.
     */
    public function actionCreate() {
        Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        $referenceselements=new referenceselements;
        $audiences=new audiences;
        $contributors=new contributors;
        $creators=new creators;
        $publishers=new publishers;
        $files=new files;
        $categoryreferences=categoryreferences::model();
        $subcategoryreferences=subcategoryreferences::model();
        $recordlevelelements = recordlevelelements::model();
        $referenceselements->created = date('m/d/Y');

        if(isset($_POST['referenceselements'])) {
            $referenceselements->attributes=$_POST['referenceselements'];

            if(isset($referenceselements->idcategoryreferences))
                $categoryreferences= $categoryreferences->findByPk($referenceselements->idcategoryreferences);
            if(isset($referenceselements->idsubcategoryreferences))
                $subcategoryreferences = $subcategoryreferences->findByPk($referenceselements->idsubcategoryreferences);

            $referenceselements->date = $referenceselements->date==''?null:$referenceselements->date;
	
		list($ano,$mes,$dia) = preg_split("/-/", $referenceselements->date);

//        $referenceselements->date = "$mes/$dia/$ano";
//        if($referenceselements->date == "//")
            $referenceselements->date = null;

//            $referenceselements->setAttribute('created', date('Y-m-d G:i:s'));
//            $referenceselements->setAttribute('modified', date('Y-m-d G:i:s'));
//            $referenceselements->setAttribute('avaiable', date('Y-m-d G:i:s'));

            $referenceselements->created = null;
            $referenceselements->modified = null;
            $referenceselements->avaiable = null;

            $audiences->attributes=$_POST['audiences'];
            $AR = WebbeeController::getFieldElement($_POST['audiences'], $audiences, "idaudiences");
            if(!$AR && WebbeeController::checkArrayNull($_POST['audiences'])) {
                $audiences->setIsNewRecord(true);
                if($audiences->save())
                    $AR = WebbeeController::getFieldElement($_POST['audiences'], $audiences, "idaudiences");
            }
            WebbeeController::setIdElementOfRecord($AR, "idaudiences", $referenceselements);


            $contributors->attributes=$_POST['contributors'];
            $AR = WebbeeController::getFieldElement($_POST['contributors'], $contributors, "idcontributors");
            if(!$AR && WebbeeController::checkArrayNull($_POST['contributors'])) {
                $contributors->setIsNewRecord(true);
                if($contributors->save())
                    $AR = WebbeeController::getFieldElement($_POST['contributors'], $contributors, "idcontributors");
            }
            WebbeeController::setIdElementOfRecord($AR, "idcontributors", $referenceselements);

            $creators = creators::model()->findByPk($referenceselements->idcreators);
         
//            $publishers = publishers::model()->findByPk($referenceselements->idpublishers);

            
            if($_POST['idfile']==""){            
           
	            //upload files
	            $files->attributes=$_POST['files'];
	            $files->path = "images/uploaded/";
	            $dir = $files->path;
	            list($name, $extension)= preg_split("/\./",$files->filename); //extensão do arquivo
	            $files->extension = $extension;
	            if(WebbeeController::checkArrayNull($_POST['files'])) {
            
	                $files->setIsNewRecord(true);
	                if($files->save()) {
               
	                    $files->filesystemname = $files->idfile.".".$files->extension;
	                    if(WebbeeController::changeFileName($files->filename, $files->filesystemname, $dir)) {
	                        if($files->update()) {
	                            $referenceselements->idfile = $files->idfile;
	                            WebbeeController::setIdElementOfRecord($files, "idfile", $referenceselements);
	                        }
	                    }
	                }
	            }
	            
            }else{
            
            	//caso nao seja para salvar um novo arquivo, apenas atualiza o model media e recria o model file
            
            	$files = files::model()->findByPk($_POST['idfile']);
            	$referenceselements->idfile = $_POST['idfile'];                
            
            }
            
			if(!$referenceselements->validate()) {
			
				$this->widget('FieldsErrors',array('models'=>array($referenceselements)));
			
//                if(isset ($_POST['recordlevelelements'])) {
//                    $this->render('create',array(
//                            'referenceselements'=>$referenceselements,
//                            'recordlevelelements'=>$recordlevelelements->findByPk($_POST['recordlevelelements']['idrecordlevelelements']),
//                            'salvo'=>false,
//                            'audiences'=>$audiences,
//                            'contributors'=>$contributors,
//                            'creators'=>$creators,
//                            'publishers'=>$publishers,
//                            'files'=>$files,
//                            'categoryreferences'=>$categoryreferences,
//                            'subcategoryreferences'=>$subcategoryreferences,
//                    ));
//                }else {
//                    $this->render('create',array(
//                            'referenceselements'=>$referenceselements,
//                            'salvo'=>false,
//                            'audiences'=>$audiences,
//                            'contributors'=>$contributors,
//                            'creators'=>$creators,
//                            'publishers'=>$publishers,
//                            'files'=>$files,
//                            'categoryreferences'=>$categoryreferences,
//                            'subcategoryreferences'=>$subcategoryreferences,
//                    ));
//
//                }
                die();
            }            

            $referenceselements->save();
            if(isset ($_POST['recordlevelelements'])) {
                $aux = $_POST['recordlevelelements'];
                $referencerecordlevel = referencerecordlevel::model();
                $referencerecordlevel->idreferenceselements = $referenceselements->idreferenceselements;
                $referencerecordlevel->idrecordlevelelements = $aux['idrecordlevelelements'];
                $referencerecordlevel->setIsNewRecord(true);
                $referencerecordlevel->save();
//                $this->redirect('index.php?r=recordlevelelements/referenceelements&id='.$aux['idrecordlevelelements']
//                        .'&idinstitutioncode='.$_GET['idinstitutioncode'].
//                        '&idcollectioncode='.$_GET['idcollectioncode'].
//                        '&catalognumber='.$_GET['catalognumber'].
//                        '&idscientificname='.$_GET['idscientificname']);
            }
//            else {
//                $this->render('create',array(
//                        'referenceselements'=>$referenceselements,
//                        'salvo'=>true,
//                        'audiences'=>$audiences,
//                        'contributors'=>$contributors,
//                        'creators'=>$creators,
//                        'publishers'=>$publishers,
//                        'files'=>$files,
//                        'categoryreferences'=>$categoryreferences,
//                        'subcategoryreferences'=>$subcategoryreferences,
//                ));
//
//            }

            echo "OK|".$referenceselements->idreferenceselements;
            
        }else {
            if(isset ($_POST['recordlevelelements'])) {
                $aux = $_POST['recordlevelelements'];
                $recordlevelelements = recordlevelelements::model();
                $this->render('create',array(
                        'referenceselements'=>$referenceselements,
                        'salvo'=>false,
                        'recordlevelelements'=>$recordlevelelements->findByPk($aux['idrecordlevelelements']),
                        'audiences'=>$audiences,
                        'contributors'=>$contributors,
                        'creators'=>$creators,
                        'publishers'=>$publishers,
                        'files'=>$files,
                        'categoryreferences'=>$categoryreferences,
                        'subcategoryreferences'=>$subcategoryreferences,
                ));
            }else {
                $this->render('create',array(
                        'salvo'=>false,
                        'referenceselements'=>$referenceselements,
                        'audiences'=>$audiences,
                        'contributors'=>$contributors,
                        'creators'=>$creators,
                        'publishers'=>$publishers,
                        'files'=>$files,
                        'categoryreferences'=>$categoryreferences,
                        'subcategoryreferences'=>$subcategoryreferences,
                ));
            }
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate() {
        $referenceselements=$this->loadreferenceselements();
        $audiences = audiences::model()->findByPk($referenceselements->idaudiences);
        $contributors= contributors::model()->findByPk($referenceselements->idcontributors);
        $creators = creators::model()->findByPk($referenceselements->idcreators);
        $publishers = publishers::model()->findByPk($referenceselements->idpublishers);
        $files = files::model()->findByPk($referenceselements->idfile);

        $categoryreferences=categoryreferences::model();
        $subcategoryreferences=subcategoryreferences::model();

        if($audiences === null) $audiences=new audiences;
        if($contributors === null) $contributors=new contributors;
        if($creators === null) $creators=new creators;
        if($publishers === null) $publishers=new publishers;
        if($files === null) $files=new files;

        //Listagem de referencias cadastradas
        $sql = "select A.idreferenceselements, A.title, D.language, B.filename
                        from referenceselements A
                        left join languages D on D.idlanguages = A.idlanguages
                        left join files B on B.idfile = A.idfile
                        where A.title <> ''";
        $references = WebbeeController::executaSQL($sql);
        
//        list($ano,$mes,$dia) = preg_split("/-/", $referenceselements->avaiable);
//        $referenceselements->avaiable = "$mes/$dia/$ano";
//        if($referenceselements->avaiable == "//")
            $referenceselements->avaiable = null;

//        list($ano,$mes,$dia) = preg_split("/-/", $referenceselements->modified);
//        $referenceselements->modified = "$mes/$dia/$ano";
//        if($referenceselements->modified == "//")
            $referenceselements->modified = null;

//        list($ano,$mes,$dia) = preg_split("/-/", $referenceselements->created);
//        $referenceselements->created = "$mes/$dia/$ano";
//        if($referenceselements->created == "//")
            $referenceselements->created = null;

//        list($ano,$mes,$dia) = preg_split("/-/", $referenceselements->date);
//        $referenceselements->date = "$mes/$dia/$ano";
//        if($referenceselements->date == "//")
            $referenceselements->date = null;

        if(isset($referenceselements->idcategoryreferences))
            $categoryreferences= $categoryreferences->findByPk($referenceselements->idcategoryreferences);
        if(isset($referenceselements->idsubcategoryreferences))
            $subcategoryreferences = $subcategoryreferences->findByPk($referenceselements->idsubcategoryreferences);

        if(isset($_POST['referenceselements'])) {

            $referenceselements->attributes=$_POST['referenceselements'];
            if(isset($referenceselements->idcategoryreferences))
                $categoryreferences= $categoryreferences->findByPk($referenceselements->idcategoryreferences);
            if(isset($referenceselements->idsubcategoryreferences))
                $subcategoryreferences = $subcategoryreferences->findByPk($referenceselements->idsubcategoryreferences);
            
            $referenceselements->date = $referenceselements->date==''?null:$referenceselements->date;

//            $referenceselements->setAttribute('created', date('Y-m-d G:i:s'));
//            $referenceselements->setAttribute('modified', date('Y-m-d G:i:s'));
//            $referenceselements->setAttribute('avaiable', date('Y-m-d G:i:s'));

//            list($mes,$dia,$ano) = preg_split("/\//", $referenceselements->date);
//            $referenceselements->date = "$ano-$mes-$dia";
//            if($referenceselements->date == "--")
                $referenceselements->date = null;

            $referenceselements->modified = date('Y-m-d');

//            list($mes,$dia,$ano) = preg_split("/\//", $referenceselements->created);
//            $referenceselements->created = "$ano-$mes-$dia";
//            if($referenceselements->created == "--")
                $referenceselements->created = null;

//            list($mes, $dia, $ano) = preg_split("/\//", $referenceselements->avaiable);
//            $referenceselements->avaiable = "$ano-$mes-$dia";
//            if($referenceselements->avaiable == "--")
                $referenceselements->avaiable = null;

            $audiences->attributes=$_POST['audiences'];
            $AR = WebbeeController::getFieldElement($_POST['audiences'], $audiences, "idaudiences");
            if(!$AR && WebbeeController::checkArrayNull($_POST['audiences'])) {
                $audiences->setIsNewRecord(true);
                if($audiences->save())
                    $AR = WebbeeController::getFieldElement($_POST['audiences'], $audiences, "idaudiences");
            }
            WebbeeController::setIdElementOfRecord($AR, "idaudiences", $referenceselements);

            $contributors->attributes=$_POST['contributors'];
            $AR = WebbeeController::getFieldElement($_POST['contributors'], $contributors, "idcontributors");
            if(!$AR && WebbeeController::checkArrayNull($_POST['contributors'])) {
                $contributors->setIsNewRecord(true);
                if($contributors->save())
                    $AR = WebbeeController::getFieldElement($_POST['contributors'], $contributors, "idcontributors");
            }
            WebbeeController::setIdElementOfRecord($AR, "idcontributors", $referenceselements);

            $creators->attributes=$_POST['creators'];
            $AR = WebbeeController::getFieldElement($_POST['creators'], $creators, "idcreators");
            if(!$AR && WebbeeController::checkArrayNull($_POST['creators'])) {
                $creators->setIsNewRecord(true);
                if($creators->save())
                    $AR = WebbeeController::getFieldElement($_POST['creators'], $creators, "idcreators");
            }
            WebbeeController::setIdElementOfRecord($AR, "idcreators", $referenceselements);

            $publishers->attributes=$_POST['publishers'];
            $AR = WebbeeController::getFieldElement($_POST['publishers'], $publishers, "idpublishers");
            if(!$AR && WebbeeController::checkArrayNull($_POST['publishers'])) {
                $publishers->setIsNewRecord(true);
                if($publishers->save())
                    $AR = WebbeeController::getFieldElement($_POST['publishers'], $publishers, "idpublishers");
            }
            WebbeeController::setIdElementOfRecord($AR, "idpublishers", $referenceselements);
           
            
            /*
             *               
             * TODO Precisa urgentemente rever toda a logica de upload
             * 
             */

            if($_POST['idfile']==""){  
            
	            //Upload files
	            $file = $_POST['file'];
	            $files->setIsNewRecord(true);
	            $files->attributes=$_POST['files'];
	            $files->path = "images/uploaded/";
	            $dir = $files->path;
	            list($name, $extension)= preg_split("/\./",$files->filename); //extensão do arquivo
	            $files->extension = $extension;
	            if(WebbeeController::checkArrayNull($_POST['files'])) {
            
	                if($file['update'])
	                    $files->setIsNewRecord(false);
	
	                if($files->save()) {
               
	                    $files->filesystemname = trim($files->idfile.".".$files->extension, " ");
	                    if(WebbeeController::changeFileName($files->filename, $files->filesystemname, $dir)) {
	                        if($files->update()) {
	                            $referenceselements->idfile = $files->idfile;
	                        }
	                    }
	                }
	            }
            
			}else{
            
            	//caso nao seja para salvar um novo arquivo, apenas atualiza o model media e recria o model file
            
            	$files = files::model()->findByPk($_POST['idfile']);
            	$referenceselements->idfile = $_POST['idfile'];                
            
            }    

           if(!$referenceselements->validate()) {
           
           		$this->widget('FieldsErrors',array('models'=>array($referenceselements)));
           
//                $this->render('create',array(
//                        'referenceselements'=>$referenceselements,
//                        'salvo'=>false,
//                        'audiences'=>$audiences,
//                        'contributors'=>$contributors,
//                        'creators'=>$creators,
//                        'publishers'=>$publishers,
//                        'files'=>$files,
//                        'categoryreferences'=>$categoryreferences,
//                        'subcategoryreferences'=>$subcategoryreferences,
//                ));
                die();
            }            
            
            if($referenceselements->save()){
            
            	echo "OK|".$referenceselements->idreferenceselements;
            
            }
//            $this->render('update',array('salvo'=>true,
//                    'referenceselements'=>$referenceselements,
//                    'categoryreferences'=>$categoryreferences,
//                    'subcategoryreferences'=>$subcategoryreferences,
//                    'audiences'=>$audiences,
//                    'contributors'=>$contributors,
//                    'creators'=>$creators,
//                    'publishers'=>$publishers,
//                    'files'=>$files,
//                    'references'=>$references, ));
        }else {

            $this->render('update',array(
                    'salvo'=>false,
                    'referenceselements'=>$referenceselements,
                    'categoryreferences'=>$categoryreferences,
                    'subcategoryreferences'=>$subcategoryreferences,
                    'audiences'=>$audiences,
                    'contributors'=>$contributors,
                    'creators'=>$creators,
                    'publishers'=>$publishers,
                    'files'=>$files,
                    'references'=>$references,
            ));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     */
    public function actionDelete() {
        if(Yii::app()->request->isPostRequest) {
            if(isset($_GET['id'])) {
                referencerecordlevel::model()->deleteAllByAttributes(array('idreferenceselements'=>$this->loadreferenceselements()->idreferenceselements));
                if($this->loadreferenceselements()->delete()) {
                    echo "Sucess";
                } else {
                    echo "Could not be deleted!";
                }
            }else {
                $referencerecordlevel = referencerecordlevel::model();
                $referencerecordlevel->idrecordlevelelements = $_GET['idrecordlevel'];
                $referencerecordlevel->idreferenceselements= $_GET['idreference'];
                if($referencerecordlevel->delete())
                    echo "Sucess";
                else
                    echo "Could not be deleted!";
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteFile() {

        if(Yii::app()->request->isPostRequest) {

            $idFile = $_POST["idfile"];
            $result = files::model()->deleteByPk(array("idfile"=>$idFile));

            $referenceselements=$this->loadreferenceselements();

            if($referenceselements!=null){

	            $referenceselements->idfile = null;
	
	            if($referenceselements->save(true, array('idfile'))){
	                $this->redirect(array('update',
	                	'id'=>$referenceselements->idreferenceselements,
	                	'idtypereferences'=>$_GET["idtypereferences"],
	                	'idsubtypereferences'=>$_GET["idsubtypereferences"],
	                	'idsubcategoryreferences'=>$_GET["idsubcategoryreferences"],
	                	'idcategoryreferences'=>$_GET["idcategoryreferences"],
	                	'title'=>$_GET["title"],	                
	                
	                ));
	            }

            }else{
            	//$referenceselements = $_POST["referenceselements"];
            	//$this->redirect(array('create','referenceselements'=>$referenceselements));
            	$this->actionCreate();            
            }

        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

    }

    /**
     * Lists all models.
     */
    public function actionList() {
        Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        $referenceselementsList = null;

        if (isset($_POST['withfile']) || isset($_POST['referenceselements']) || isset($_GET['idtypereferences']) || isset($_GET['idsubtypereferences']) || isset($_GET['title']) || isset($_GET['idsubtypereferences'])
                || isset($_GET['idcategoryreferences']) || isset($_GET['idsubcategoryreferences'])) {

            if (isset($_POST['referenceselements'])) {
                $ref = $_POST['referenceselements'];
                $withfile = $_POST['withfile'];
            }
            else {
                $ref['idtypereferences'] = $_GET['idtypereferences'];
                $ref['idsubtypereferences'] = $_GET['idsubtypereferences'];
                $ref['title'] = $_GET['title'];
                $ref['idcategoryreferences'] = $_GET['idcategoryreferences'];
                $ref['idsubcategoryreferences'] = $_GET['idsubcategoryreferences'];
                $ref['isrestricted'] = $_GET['isrestricted'];
                $withfile = $_GET['withfile'];
            }

            if($withfile || $med['isrestricted'] <> '0' || $ref['idtypereferences'] <> "" || $ref['idsubtypereferences'] <> "" || $ref['title'] <> "" || $ref['idcategoryreferences'] <> "" ||
                    $ref['idsubcategoryreferences'] <> "") {
                $criteria=new CDbCriteria;

                $criteria->condition = "1=1";
                $criteria->condition .= ($ref['idtypereferences'] == "" ? "" : " AND referenceselements.idtypereferences = ".$ref['idtypereferences']);
                $criteria->condition .= ($ref['idsubtypereferences'] == "" ? "" : " AND referenceselements.idsubtypereferences = ".$ref['idsubtypereferences']);
                $criteria->condition .= ($ref['title'] == "" ? "" : " AND UPPER(title) like UPPER('%".$ref['title']."%')");
                $criteria->condition .= ($ref['idcategoryreferences'] == "" ? "" : " AND referenceselements.idcategoryreferences = ".$ref['idcategoryreferences']);
                $criteria->condition .= ($ref['idsubcategoryreferences'] == "" ? "" : " AND referenceselements.idsubcategoryreferences = ".$ref['idsubcategoryreferences']);
                $criteria->condition .= ($ref['isrestricted'] == false ? "" : " AND isrestricted = true");
                $criteria->condition .= ($withfile == false ? "" : " AND (idfile > 0 OR \"URI\"<>'')");

                $criteria->join = "LEFT JOIN typereferences as typereferences ON typereferences.idtypereferences = referenceselements.idtypereferences
                                LEFT JOIN subtypereferences as subtypereferences ON subtypereferences.idsubtypereferences = referenceselements.idsubtypereferences
                                 LEFT JOIN categoryreferences ON categoryreferences.idcategoryreferences = referenceselements.idcategoryreferences
                               LEFT JOIN subcategoryreferences ON subcategoryreferences.idsubcategoryreferences = referenceselements.idsubcategoryreferences";
                $criteria->order = "title";

                $pages=new CPagination(referenceselements::model()->count($criteria));

                $pages->pageSize=self::PAGE_SIZE;

                $pages->params = array(
                        "idtypereferences"=>$ref['idtypereferences'],
                        "idsubtypereferences"=>$ref['idsubtypereferences'],
                        "title"=>$ref['title'],
                        "idcategoryreferences"=>$ref['idcategoryreferences'],
                        "idsubcategoryreferences"=>$ref['idsubcategoryreferences'],
                        "idrecordlevelelements"=>isset($_GET['idrecordlevelelements'])?$_GET['idrecordlevelelements']:'',
                        "isrestricted"=>$ref['isrestricted'],
                        "withfile"=>$withfile,
                        'idinstitutioncode'=>$_GET['idinstitutioncode'],
                        'idcollectioncode'=>$_GET['idcollectioncode'],
                        'catalognumber'=>$_GET['catalognumber'],
                        'idscientificname='=>$_GET['idscientificname'],
                );

                $pages->applyLimit($criteria);

                $referenceselementsList=referenceselements::model()->with('categoryreference','typereference')->findAll($criteria);

            }
        }

        $referenceselements = referenceselements::model();

        if($ref['idtypereferences']!="")
            $typereferences = typereferences::model()->findByPk($ref['idtypereferences']);
        else
            $typereferences = typereferences::model();

        if($ref['idsubtypereferences']!="")
            $subtypereferences = subtypereferences::model()->findByPk($ref['idsubtypereferences']);
        else
            $subtypereferences = subtypereferences::model();

        if($ref['idcategoryreferences']!="")
            $categoryreferences = categoryreferences::model()->findByPk($ref['idcategoryreferences']);
        else
            $categoryreferences = categoryreferences::model();

        if($ref['idsubcategoryreferences']!="")
            $subcategoryreferences = subcategoryreferences::model()->findByPk($ref['idsubcategoryreferences']);
        else
            $subcategoryreferences = subcategoryreferences::model();

        $referenceselements->title= $ref['title'];
        $referenceselements->idtypereferences = $typereferences->idtypereferences;
        $referenceselements->idsubtypereferences = $subtypereferences->idsubtypereferences;
        $referenceselements->idcategoryreferences = $categoryreferences->idcategoryreferences;
        $referenceselements->idsubcategoryreferences = $subcategoryreferences->idsubcategoryreferences;
        $referenceselements->isrestricted = $ref['isrestricted'];
        $withfile = $_GET['withfile'];

        if(isset ($_POST['recordlevelelements'])) {
            $recordlevelelements = recordlevelelements::model()->findByPk($_POST['recordlevelelements']['idrecordlevelelements']);
        }else {
            if(isset ($_GET['idrecordlevelelements'])) {
                $recordlevelelements = recordlevelelements::model()->findByPk($_GET['idrecordlevelelements']);
            }
        }

        $this->render('list',array(
                'referenceselementsList'=>$referenceselementsList,
                'recordlevelelements'=>$recordlevelelements,
                'referenceselements'=>$referenceselements,
                'typereferences'=>$typereferences,
                'subtypereferences'=>$subtypereferences,
                'subcategoryreferences'=>$subcategoryreferences,
                'categoryreferences'=>$categoryreferences,
                'pages'=>$pages,
        ));


    }





    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->processAdminCommand();

        $criteria=new CDbCriteria;

        $pages=new CPagination(referenceselements::model()->count($criteria));
        $pages->pageSize=self::PAGE_SIZE;
        $pages->applyLimit($criteria);

        $sort=new CSort('referenceselements');
        $sort->applyOrder($criteria);

        $referenceselementss=referenceselements::model()->findAll($criteria);

        $this->render('admin',array(
                'referenceselements'=>$referenceselements,
                'pages'=>$pages,
                'sort'=>$sort,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadreferenceselements($id=null) {
        if($this->_model===null) {
            if($id!==null || isset($_GET['id']))
                $this->_model=referenceselements::model()->findbyPk($id!==null ? $id : $_GET['id']);
//			if($this->_model===null)
//				throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }

    /**
     * Executes any command triggered on the admin page.
     */
    protected function processAdminCommand() {
        if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete') {
            $this->loadreferenceselements($_POST['id'])->delete();
            // reload the current page to avoid duplicated delete actions
            $this->refresh();
        }
    }
}

