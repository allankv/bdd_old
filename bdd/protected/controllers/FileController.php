<?php
include 'logic/FileLogic.php';
class FileController extends CController {
    const PAGE_SIZE=10;
    public $defaultAction='goToMaintain';

    public function actionGoToMaintain() {
        if($_GET['id']!=null && FileAR::model()->findByPk($_GET['id'])!=null) {
            $file = FileAR::model()->findByPk($_GET['id']);
        }else {
            $file = FileAR::model();
        }

        $logic = new FileLogic();
        $file = $logic->fillDependency($file);

        if((Yii::app()->request->isPostRequest)) {
            $rs = $logic->save($file);            
            if($rs['success']) {
                $file = FileAR::model()->findByPk($rs["id"]);
            }else {

            }
        }
        $this->renderPartial('maintain',
                array_merge(array(
                'file'=>$file,
                )
        ));

    }

	public function actionGetFile(){
        $logic = new FileLogic();
        $sp = FileAR::model()->findByPk($_POST['id']);
        $rs = array();
        $rs['ar'] = $sp->getAttributes();
        
        echo CJSON::encode($rs);	
	
	}

	public function actionSave(){
	
		$ar = new FileAR();
        $ar->filename=$_POST['filename'];
        $ar->filesystemname=$_POST['filename'];
        
        $ar->path=$this->curPageURL().'../tmp/';

        $logic = new FileLogic();        
        
        $rs = $logic->save($ar);

        echo CJSON::encode($rs);	

	}
	function curPageURL() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 $rs = explode("index.php", $pageURL);
	 return $rs[0];
	}

    public function actionDelete() {
        $logic = new FileLogic();
        $logic->delete($_GET['idFile']);

        echo "OK";
    }


    public function filters() {
        return array(
                'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
                array('deny',
                        'users'=>array('?'),
                ),
        );
    }

}
