<?php
class RecordedByLogic {
    var $mainAtt = 'recordedby';
    public function search($q) {
        $ar = RecordedByAR::model();
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
            $ln= array ("key"=>"".$ar->idrecordedby,"value"=>$ar->recordedby);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = RecordedByAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new RecordedByAR();
        $rs = array();

        $ar->recordedby = $field;
        $ar->idrecordedby = $id;

        if(isset($ar->idrecordedby)) {
            $returnAR = RecordedByAR::model()->findByPk($ar->idrecordedby);
        }else {
            $ar->recordedby = trim(addslashes($ar->recordedby));
            $returnAR = RecordedByAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->recordedby."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idrecordedby;
            $rs['field'] = $returnAR->recordedby;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($q) {
        $rs = array ();
        $ar = new RecordedByAR();
        $ar->recordedby = trim(addslashes($q));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idrecordedby == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idrecordedby;
            $rs['field'] = $rs['ar']->recordedby;
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
    public function getRecordedByByOccurrenceElement($ar) {
        $nnList = OccurrenceRecordedByAR::model()->findAll('idoccurrenceelement='.$ar->idoccurrenceelement);
        $recordedbyList = array();
        foreach ($nnList as $n) {
            $recordedbyList[] = RecordedByAR::model()->findByPk($n->idrecordedby);
        }
        return $recordedbyList;
    }
    public function saveOccurrenceElementNN($idRecordedBy,$idOccurrenceElement) {
        if(OccurrenceRecordedByAR::model()->find("idrecordedby=$idRecordedBy AND idoccurrenceelement=$idOccurrenceElement")==null) {
            $ar = OccurrenceRecordedByAR::model();
            $ar->idrecordedby = $idRecordedBy;
            $ar->idoccurrenceelement = $idOccurrenceElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteOccurrenceElementNN($idRecordedBy,$idOccurrenceElement) {
        $ar = OccurrenceRecordedByAR::model();
        $ar = $ar->find(" idrecordedby=$idRecordedBy AND idoccurrenceelement=$idOccurrenceElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteOccurrenceRecord($id){
        $ar = OccurrenceRecordedByAR::model();
        $arList = $ar->findAll(" idoccurrenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
    public function getRecordedByByCuratorialElement($ar) {
        $nnList = CuratorialRecordedByAR::model()->findAll('idcuratorialelement='.$ar->idcuratorialelement);
        $recordedbyList = array();
        foreach ($nnList as $n=>$ar) {
            $recordedbyList[] = RecordedByAR::model()->findByPk($ar->idrecordedby);
        }
        return $recordedbyList;
    }
    public function saveCuratorialElementNN($idRecordedBy,$idCuratorialElement) {
        if(CuratorialRecordedByAR::model()->find("idrecordedby=$idRecordedBy AND idcuratorialelement=$idCuratorialElement")==null) {
            $ar = CuratorialRecordedByAR::model();
            $ar->idrecordedby = $idRecordedBy;
            $ar->idcuratorialelement = $idCuratorialElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteCuratorialElementNN($idRecordedBy,$idCuratorialElement) {
        $ar = CuratorialRecordedByAR::model();
        $ar = $ar->find(" idrecordedby=$idRecordedBy AND idcuratorialelement=$idCuratorialElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteCuratorialRecord($id){
        $ar = CuratorialRecordedByAR::model();
        $arList = $ar->findAll(" idcuratorialelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
