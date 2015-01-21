<?php
class GeoreferenceSourceLogic {
    var $mainAtt = 'georeferencesource';
    public function search($q) {
        $ar = GeoreferenceSourceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idgeoreferencesource+"","label"=>$ar->georeferencesource,"value"=>$ar->georeferencesource);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = GeoreferenceSourceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new GeoreferenceSourceAR();
        $rs = array();

        $ar->georeferencesource = $field;
        $ar->idgeoreferencesource = $id;

        if(isset($ar->idgeoreferencesource)) {
            $returnAR = GeoreferenceSourceAR::model()->findByPk($ar->idgeoreferencesource);
        }else {
            $ar->georeferencesource = trim($ar->georeferencesource);
            $returnAR = GeoreferenceSourceAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->georeferencesource."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idgeoreferencesource;
            $rs['field'] = $returnAR->georeferencesource;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = GeoreferenceSourceAR::model();
        $ar->georeferencesource = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idgeoreferencesource == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idgeoreferencesource;
            $rs['field'] = $rs['ar']->georeferencesource;
            $rs['ar'] = $rs['ar']->getAttributes();

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
    public function getGeoreferenceSourceByLocalityElement($ar) {
        $nnList = LocalityGeoreferenceSourceAR::model()->findAll('idlocalityelement='.$ar->idlocalityelement);
        $georeferencesourceList = array();
        foreach ($nnList as $n) {
            $georeferencesourceList[] = GeoreferenceSourceAR::model()->findByPk($n->idgeoreferencesource);
        }
        return $georeferencesourceList;
    }
    public function saveLocalityElementNN($idGeoreferenceSource,$idLocalityElement) {
        if(LocalityGeoreferenceSourceAR::model()->find("idgeoreferencesource=$idGeoreferenceSource AND idlocalityelement=$idLocalityElement")==null) {
            $ar = LocalityGeoreferenceSourceAR::model();
            $ar->idgeoreferencesource = $idGeoreferenceSource;
            $ar->idlocalityelement = $idLocalityElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteLocalityElementNN($idGeoreferenceSource,$idLocalityElement) {
        $ar = LocalityGeoreferenceSourceAR::model();
        $ar = $ar->find(" idgeoreferencesource=$idGeoreferenceSource AND idlocalityelement=$idLocalityElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteLocalityRecord($id){
        $ar = LocalityGeoreferenceSourceAR::model();
        $arList = $ar->findAll(" idlocalityelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
    public function getGeoreferenceSourceByGeospatialElement($ar) {
        $nnList = GeospatialGeoreferenceSourceAR::model()->findAll('idgeospatialelement='.$ar->idgeospatialelement);
        $georeferencesourceList = array();
        foreach ($nnList as $n) {
            $georeferencesourceList[] = GeoreferenceSourceAR::model()->findByPk($n->idgeoreferencesource);
        }
        return $georeferencesourceList;
    }
    public function saveGeospatialElementNN($idGeoreferenceSource,$idGeospatialElement) {
        if(GeospatialGeoreferenceSourceAR::model()->find("idgeoreferencesource=$idGeoreferenceSource AND idgeospatialelement=$idGeospatialElement")==null) {
            $ar = GeospatialGeoreferenceSourceAR::model();
            $ar->idgeoreferencesource = $idGeoreferenceSource;
            $ar->idgeospatialelement = $idGeospatialElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteGeospatialElementNN($idGeoreferenceSource,$idGeospatialElement) {
        $ar = GeospatialGeoreferenceSourceAR::model();
        $ar = $ar->find(" idgeoreferencesource=$idGeoreferenceSource AND idgeospatialelement=$idGeospatialElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteGeospatialRecord($id){
        $ar = GeospatialGeoreferenceSourceAR::model();
        $arList = $ar->findAll(" idgeospatialelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
