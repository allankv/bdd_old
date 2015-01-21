<?php
class PreparationLogic {
    var $mainAtt = 'preparation';
    public function search($q) {
        $ar = PreparationAR::model();
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
            $ln= array ("key"=>"".$ar->idpreparation,"value"=>$ar->preparation);
            $result[] = $ln;
        }
        
        return $result;
    }
    public function suggestion($q) {
        $ar = PreparationAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new PreparationAR();
        $rs = array();

        $ar->preparation = $field;
        $ar->idpreparation = $id;


        if(isset($ar->idpreparation)) {
            $returnAR = PreparationAR::model()->findByPk($ar->idpreparation);
        }else {
            $ar->preparation = trim(addslashes($ar->preparation));
            $returnAR = PreparationAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->preparation."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idpreparation;
            $rs['field'] = $returnAR->preparation;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($q) {
        $rs = array ();
        $ar = new PreparationAR();
        $ar->preparation = trim(addslashes($q));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idpreparation == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idpreparation;
            $rs['field'] = $rs['ar']->preparation;
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
    public function getPreparationByOccurrenceElement($ar) {
        $nnList = OccurrencePreparationAR::model()->findAll('idoccurrenceelement='.$ar->idoccurrenceelement);
        $preparationList = array();
        foreach ($nnList as $n=>$ar) {
            $preparationList[] = PreparationAR::model()->findByPk($ar->idpreparation);
        }
        return $preparationList;
    }
    public function saveOccurrenceElementNN($idPreparation,$idOccurrenceElement) {
        if(OccurrencePreparationAR::model()->find("idpreparation=$idPreparation AND idoccurrenceelement=$idOccurrenceElement")==null) {
            $ar = new OccurrencePreparationAR();
            $ar->idpreparation = $idPreparation;
            $ar->idoccurrenceelement = $idOccurrenceElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteOccurrenceElementNN($idPreparation,$idOccurrenceElement) {
        $ar = OccurrencePreparationAR::model();
        $ar = $ar->find(" idpreparation=$idPreparation AND idoccurrenceelement=$idOccurrenceElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteOccurrenceRecord($id){
        $ar = OccurrencePreparationAR::model();
        $arList = $ar->findAll(" idoccurrenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
    public function getPreparationByCuratorialElement($ar) {
        $nnList = CuratorialPreparationAR::model()->findAll('idcuratorialelement='.$ar->idcuratorialelement);
        $preparationList = array();
        foreach ($nnList as $n=>$ar) {
            $preparationList[] = PreparationAR::model()->findByPk($ar->idpreparation);
        }
        return $preparationList;
    }
    public function saveCuratorialElementNN($idPreparation,$idCuratorialElement) {
        if(CuratorialPreparationAR::model()->find("idpreparation=$idPreparation AND idcuratorialelement=$idCuratorialElement")==null) {
            $ar = CuratorialPreparationAR::model();
            $ar->idpreparation = $idPreparation;
            $ar->idcuratorialelement = $idCuratorialElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteCuratorialElementNN($idPreparation,$idCuratorialElement) {
        $ar = CuratorialPreparationAR::model();
        $ar = $ar->find(" idpreparation=$idPreparation AND idcuratorialelement=$idCuratorialElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteCuratorialRecord($id){
        $ar = CuratorialPreparationAR::model();
        $arList = $ar->findAll(" idcuratorialelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
