<?php
class GeoreferencedByLogic {
    var $mainAtt = 'georeferencedby';
    public function search($q) {
        $ar = GeoreferencedByAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();
        $ln= array ("key"=>"","value"=>$q." <br>(New)</br>");
            $result[] = $ln;
        foreach ($rs as $n=>$ar) {
            $ln= array ("key"=>"".$ar->idgeoreferencedby,"value"=>$ar->georeferencedby);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = GeoreferencedByAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new GeoreferencedByAR();
        $rs = array();

        $ar->georeferencedby = $field;
        $ar->idgeoreferencedby = $id;

        if(isset($ar->idgeoreferencedby)) {
            $returnAR = GeoreferencedByAR::model()->findByPk($ar->idgeoreferencedby);
        }else {
            $ar->georeferencedby = trim($ar->georeferencedby);
            $returnAR = GeoreferencedByAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->georeferencedby."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idgeoreferencedby;
            $rs['field'] = $returnAR->georeferencedby;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($q) {
        $rs = array ();
        $ar = new GeoreferencedByAR();
        $ar->georeferencedby = trim(addslashes($q));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idgeoreferencedby == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idgeoreferencedby;
            $rs['field'] = $rs['ar']->georeferencedby;
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
    public function getGeoreferencedByByLocalityElement($ar) {
        $nnList = LocalityGeoreferencedByAR::model()->findAll('idlocalityelement='.$ar->idlocalityelement);
        $georeferencedbyList = array();
        foreach ($nnList as $n=>$ar) {
            $georeferencedbyList[] = GeoreferencedByAR::model()->findByPk($ar->idgeoreferencedby);
        }
        return $georeferencedbyList;
    }
    public function saveLocalityElementNN($idGeoreferencedBy,$idLocalityElement) {
        if(LocalityGeoreferencedByAR::model()->find("idgeoreferencedby=$idGeoreferencedBy AND idlocalityelement=$idLocalityElement")==null) {
            $ar = new LocalityGeoreferencedByAR();
            $ar->idgeoreferencedby = $idGeoreferencedBy;
            $ar->idlocalityelement = $idLocalityElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteLocalityElementNN($idGeoreferencedBy,$idLocalityElement) {
        $ar = LocalityGeoreferencedByAR::model();
        $ar = $ar->find(" idgeoreferencedby=$idGeoreferencedBy AND idlocalityelement=$idLocalityElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteLocalityRecord($id){
        $ar = LocalityGeoreferencedByAR::model();
        $arList = $ar->findAll(" idlocalityelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
