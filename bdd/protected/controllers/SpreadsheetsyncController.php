<?php
ini_set('max_execution_time','60000000000000000000000');
ini_set("memory_limit","1528M");
include_once 'logic/FileLogic.php';
include_once 'logic/ExportExcelLogic.php';
include_once 'logic/ImportExcelLogic.php';
class SpreadsheetsyncController extends CController {
    const PAGE_SIZE=10;
    public $defaultAction='index';
    public function filters() {
        //return array(
        //        'accessControl', // perform access control for CRUD operations
        //);
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
                array('allow',
                        'actions'=>array('*'),
                        'users'=>array('*'),
                )
        );
    }
    public function actionIndex() {
        //Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
        $this->render('index');

    }
    public function actionImport() {
        $this->render('import');
    }
    public function actionExport() {
        $this->render('export');
    }
    public function actionStartExport() {
    	//
        $hidden = $_POST['hidden'];
        $filter = $_POST['filter'];//CJSON::encode($_POST['filter']);
	
        if($filter){
            foreach ($filter as &$v) {
                //$v["class"] = "xlsBeans.Filter";
                $v["category"] = urldecode($v["category"]);
                $v["controller"] = urldecode($v["controller"]);
                $v["name"] = urldecode($v["name"]);

                $v["category"] = urlencode($v["category"]);
                $v["controller"] = urlencode($v["controller"]);
                $v["name"] = urlencode($v["name"]);
                $v["id"] = urlencode($v["id"]);

            }
		$t;
		$t["filter"][0]["controller"]="idgroup";
		$t["filter"][0]["id"]=Yii::app()->user->getGroupId()."";
		foreach($filter as $v){
			$t["filter"][] = $v;
		}
		$tmp["list"] = $t; 
		$filter = $tmp;
	}else{
		$t;
                $t["filter"][0]["controller"]="idgroup";
                $t["filter"][0]["id"]=Yii::app()->user->getGroupId()."";
		$tmp["list"] = $t;
		$filter = $tmp;
	}
	
        $ch = curl_init('http://127.0.0.1:8080/spreadsheetsync_database/sync/export/occurrence/'.urlencode(CJSON::encode($hidden).'-S-'.CJSON::encode($filter)));

 //echo  'http://127.0.0.1:8080/spreadsheetsync/sync/export/occurrence/'.urlencode(CJSON::encode($hidden).'-S-'.CJSON::encode($filter));

        $rs = curl_exec($ch); // Perform a CURL session
		curl_close($ch); // Close a CURL session
        echo substr($rs,0,-1);;       
    }
    public function actionStartExport_monitoring() {
    	//
       
        $list['list'];
        $filter['filter'];//CJSON::encode($_POST['filter']);
        $aux = $_POST['filter'];
        $filter['filter'][0]["entity"] = "idgroup";
	$filter['filter'][0]["value"] = Yii::app()->user->getGroupId()."";
	$i=1;
        if($aux){
            foreach ($aux as &$v) {
                $filter['filter'][$i]["entity"] = urldecode($v["controller"]);
                $filter['filter'][$i]["value"] = urldecode($v["id"]);
                $i++;
                /*$v["category"] = urlencode($v["category"]);
                $v["controller"] = urlencode($v["controller"]);
                $v["name"] = urlencode($v["name"]);
                $v["id"] = urlencode($v["id"]);*/

            }
        }
        $list['list'] = $filter;
        if($filter==null)
        	$list = '{}';
/*
        echo urlencode(CJSON::encode($list));
		echo CJSON::encode($list);
//*/
		
        $ch = curl_init('http://127.0.0.1:8080/spreadsheetsync_database/sync/exportM/monitoring/'.urlencode(CJSON::encode($list)));
        $rs = curl_exec($ch); // Perform a CURL session
	curl_close($ch); // Close a CURL session
        echo substr($rs,0,-1);  

    }
    public function actionStartImport() {
    //    $file["class"] = "file";
  //      $file["path"] = urldecode(str_replace('index.php', '',$_SERVER['SCRIPT_FILENAME']).'/images/uploaded/'.$_POST['fileName']);
        $ch = curl_init('http://127.0.0.1:8080/spreadsheetsync_database/sync/import/occurrence/'.urlencode($_POST["fileName"].'-'.Yii::app()->user->getGroupId().'-'.Yii::app()->user->id));
       // echo $_POST["fileName"];
	$rs = curl_exec($ch); 
        curl_close($ch);
        echo substr($rs,0,-1); 
        
    }
     public function actionStartImport_monitoring() {
     	$f["file"]["fileName"] = urlencode($_POST["fileName"]);
//     	$f["file"]["fileName"] = urlencode('/mnt/hd/php/jun/tmp/'.$_POST["fileName"]);

	$f["file"]["id"] = "".Yii::app()->user->getGroupId(); 
		//echo urlencode(CJSON::encode($f));
		//echo CJSON::encode($f);
     	$ch = curl_init('http://127.0.0.1:8080/spreadsheetsync_database/sync/importM/monitoring/'.urlencode(CJSON::encode($f)));
//     	$ch = curl_init('http://127.0.0.1:8080/spreadsheetsync/sync/importM/monitoring/'.urlencode(CJSON::encode($f)));


        $rs = curl_exec($ch); 
        curl_close($ch);
        echo substr($rs,0,-1); 
    }
    public function actionTest() {
        $ch = curl_init("https://api.facebook.com/method/fql.query?query=SELECT user FROM user WHERE name='".$_GET['name']."'&access_token=107681159329383|2.AQDCS2xnrDqPMpjr.3600.1311476400.0-100000020476669|CnLhqiB9X-qU3ET8seoWnVTN6aA&format=json");
        $rs = curl_exec($ch); 
        //curl_close($ch);
        echo $rs; 
    }
    
    
    public function actionImport_Monitoring() {
        $this->render('import_monitoring');
    }
    public function actionExport_Monitoring() {
        $this->render('export_monitoring');
    }
}
?>
