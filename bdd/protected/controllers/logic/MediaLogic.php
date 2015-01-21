<?php
include_once 'CategoryMediaLogic.php';
include_once 'TypeMediaLogic.php';
include_once 'CreatorLogic.php';
include_once 'TagLogic.php';
include_once 'SpecimenLogic.php';
include_once 'SpeciesLogic.php';
class MediaLogic {
    public function filter($filter) {
        $c = array();
        $rs = array();
        // where de cada entidade com OR entre
        $categoryMediaWhere = '';
        $titleWhere = '';
        $typeMediaWhere = '';

        //Filter out already related Media records
        $relatedMediaWhere = '';

        
        if($filter['list']!=null) {
            foreach ($filter['list'] as &$v) {
                if($v['controller']=='categorymedia') {
                    $categoryMediaWhere = $categoryMediaWhere==''?'':$categoryMediaWhere.' OR ';
                    $categoryMediaWhere = $categoryMediaWhere.' cm.idcategorymedia = '.$v['id'];
                }
                if($v['controller']=='media') {
                    $titleWhere = $titleWhere==''?'':$titleWhere.' OR ';
                    $titleWhere = $titleWhere.' media.title ilike \'%'.$v['id'].'%\''.' OR difference(media.title, \''.$v['id'].'\') > 3';
                }
                if($v['controller']=='typemedia') {
                    $typeMediaWhere = $typeMediaWhere==''?'':$typeMediaWhere.' OR ';
                    $typeMediaWhere = $typeMediaWhere.' typemedia.idtypemedia = '.$v['id'];
                }
            }

        }

        if($filter['mediaFilterList'] != null)
        {
            foreach ($filter['mediaFilterList'] as $key => $value)
            {
                $relatedMediaWhere = $relatedMediaWhere==''?'':$relatedMediaWhere.' AND ';
                $relatedMediaWhere = $relatedMediaWhere.' media.idmedia <> '.$value;
            }
        }
        
        // se o where de cada entidades nao estiver vazias, coloca AND antes
        $categoryMediaWhere = $categoryMediaWhere!=''?' AND ('.$categoryMediaWhere.') ':'';
        $titleWhere = $titleWhere!=''?' AND ('.$titleWhere.') ':'';
        $typeMediaWhere = $typeMediaWhere!=''?' AND ('.$typeMediaWhere.') ':'';
        $relatedMediaWhere = $relatedMediaWhere!=''?' AND ('.$relatedMediaWhere.') ':'';
        // parametros da consulta
        $c['select'] = 'SELECT media.idmedia, media.isrestricted, media.title, cm.categorymedia, typemedia.typemedia, st.subtype, scm.subcategorymedia, file.filesystemname, file.path, file.size ';
        $c['from'] = ' FROM media ';
        $c['join'] = $c['join'].' LEFT JOIN categorymedia cm ON media.idcategorymedia = cm.idcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN subcategorymedia scm ON media.idsubcategorymedia = scm.idsubcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN subtype st ON media.idsubtype = st.idsubtype ';
        $c['join'] = $c['join'].' LEFT JOIN typemedia ON media.idtypemedia = typemedia.idtypemedia ';
        $c['join'] = $c['join'].' LEFT JOIN file ON media.idfile = file.idfile ';
        
        $idGroup = Yii::app()->user->getGroupId();
        
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (idgroup='.$idGroup.') ';
        }
        
        $c['where'] = ' WHERE 1 = 1 '.$categoryMediaWhere.$titleWhere.$typeMediaWhere.$relatedMediaWhere.$groupSQL;
        $c['orderby'] = ' ORDER BY media.title ';
        $c['limit'] = ' limit '.$filter['limit'];
        $c['offset'] = ' offset '.$filter['offset'];
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'].$c['limit'].$c['offset'];
        // faz consulta e manda para list
        //echo $sql;die();
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    public function search($q) {

        /*
        $typeMediaLogic = new TypeMediaLogic();
        $typeMediaList = $typeMediaLogic->search($q);
        $categoryMediaLogic = new CategoryMediaLogic();
        $categoryMediaList = $categoryMediaLogic->search($q);*/

        //Temporary - need to change search function - using searchList for now
        $typeMediaLogic = new TypeMediaLogic();
        $typeMediaList = $typeMediaLogic->search($q);
        $categoryMediaLogic = new CategoryMediaLogic();
        $categoryMediaList = $categoryMediaLogic->searchList($q);

        $rs = array();
        $rs[] = array("controller" => "media","id" => $q,"label" => $q, "category" => "Title");
        foreach($categoryMediaList as $n=>$ar) {
            $rs[] = array("controller" => "categorymedia","id" => $ar->idcategorymedia,"label" => $ar->categorymedia,"category" => "Category");
        }
        foreach($typeMediaList as $n=>$ar) {
            $rs[] = array("controller" => "typemedia","id" => $ar->idtypemedia,"label" => $ar->typemedia,"category" => "Type");
        }
        return $rs;
    }
    public function save($ar) {
        $ar->modified=date('Y-m-d G:i:s');
        $ar->timedigitized = $ar->timedigitized==''?null:$ar->timedigitized;
        $ar->datedigitized = $ar->datedigitized==''?null:$ar->datedigitized;
        $ar->dateavailable = $ar->dateavailable==''?null:$ar->dateavailable;
        $ar->idgroup = Yii::app()->user->getGroupId();
        
        $rs = array ();
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idmedia == null?'created':'updated';
            $ar->setIsNewRecord($rs['operation']=='created');
            $aux = array();
            $aux[] = 'Successfully '.$rs['operation'].' media record titled <b>'.$ar->title.'</b>';
            //$aux[] = $rs['operation'].' success.';
            $rs['msg'] = $aux;
            $ar->idmedia = $ar->getIsNewRecord()?null:$ar->idmedia;
            $ar->save();
            $rs['id'] = $ar->idmedia;
            return $rs;
        }else {
            $erros = array ();
            foreach($ar->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $rs['success'] = false;
            $rs['msg'] = $erros;
            return $rs;
        }
    }
    
    
    public function delete($id) {
        $ar = MediaAR::model();
        $ar = $ar->findByPk($id);
        $l = new CreatorLogic();
        $l->deleteMediaRecord($id);
        $l = new TagLogic();
        $l->deleteMediaRecord($id);
        $l = new SpecimenLogic();
        $l->deleteMedia($id);
        $l = new SpeciesLogic();
        $l->deleteMedia($id);
        $ar->delete();
    }
    public function fillDependency($ar) {
        if($ar->language==null)
            $ar->language = LanguageAR::model();
        if($ar->provider==null)
            $ar->provider = ProviderAR::model();
        if($ar->metadataprovider==null)
            $ar->metadataprovider = MetadataProviderAR::model();
        if($ar->subtype==null)
            $ar->subtype= SubTypeAR::model();
        if($ar->formatmedia==null)
            $ar->formatmedia = FormatMediaAR::model();
        if($ar->capturedevice==null)
            $ar->capturedevice = CaptureDeviceAR::model();
        if($ar->typemedia==null)
            $ar->typemedia = TypeMediaAR::model();
        if($ar->subcategorymedia==null)
            $ar->subcategorymedia = SubCategoryMediaAR::model();
        if($ar->categorymedia==null)
            $ar->categorymedia = CategoryMediaAR::model();
        if($ar->file==null)
            $ar->file = FileAR::model();
        if($ar->fileformat==null)
            $ar->fileformat = FileFormatAR::model();

        return $ar;
    }
    public function showMedia ($filter)
    {
        $showMediaWhere = '';

        if($filter['mediaShowList'] != null)
        {
            foreach ($filter['mediaShowList'] as $key => $value)
            {
                $showMediaWhere = $showMediaWhere==''?'':$showMediaWhere.' OR ';
                $showMediaWhere = $showMediaWhere.' media.idmedia = '.$value;
            }
        }

        else
            $showMediaWhere = ' media.idmedia = 0';

        $showMediaWhere = $showMediaWhere!=''?' AND ('.$showMediaWhere.') ':'';
        // parametros da consulta
        $c['select'] = 'SELECT media.idmedia, media.isrestricted, media.title, cm.categorymedia, typemedia.typemedia, st.subtype, scm.subcategorymedia, file.filesystemname, file.path ';
        $c['from'] = ' FROM media ';
        $c['join'] = $c['join'].' LEFT JOIN categorymedia cm ON media.idcategorymedia = cm.idcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN subcategorymedia scm ON media.idsubcategorymedia = scm.idsubcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN subtype st ON media.idsubtype = st.idsubtype ';
        $c['join'] = $c['join'].' LEFT JOIN typemedia ON media.idtypemedia = typemedia.idtypemedia ';
        $c['join'] = $c['join'].' LEFT JOIN file ON media.idfile = file.idfile ';
        $c['where'] = ' WHERE 1 = 1 '.$showMediaWhere;
        $c['orderby'] = ' ORDER BY media.title ';
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'];
        // faz consulta e manda para list
        //echo $sql;die();
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;

    }
    public function saveSpecimenNN($idmedia, $idspecimen) {
        if(SpecimenMediaAR::model()->find("idspecimen=$idspecimen AND idmedia=$idmedia")==null) {
            $ar = SpecimenMediaAR::model();
            $ar->idspecimen = $idspecimen;
            $ar->idmedia = $idmedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpecimenNN($idmedia, $idspecimen) {
        $ar = SpecimenMediaAR::model();
        $ar = $ar->find(" idspecimen=$idspecimen AND idmedia=$idmedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpecimen($idspecimen) {
        $ar = SpecimenMediaAR::model();
        $arList = $ar->findAll(" idspecimen=$idspecimen ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
    public function saveSpeciesNN($idmedia, $idspecies) {
        if(SpeciesMediaAR::model()->find("idspecies=$idspecies AND idmedia=$idmedia")==null) {
            $ar = SpeciesMediaAR::model();
            $ar->idspecies = $idspecies;
            $ar->idmedia = $idmedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idmedia, $idspecies) {
        $ar = SpeciesMediaAR::model();
        $ar = $ar->find(" idspecies=$idspecies AND idmedia=$idmedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpecies($idspecies) {
        $ar = SpeciesMediaAR::model();
        $arList = $ar->findAll(" idspecies=$idspecies ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
}
?>
