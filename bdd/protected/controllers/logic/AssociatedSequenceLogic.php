<?php
class AssociatedSequenceLogic {
    var $mainAtt = 'associatedsequence';
    public function search($q) {
        $ar = AssociatedSequenceAR::model();
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
            $ln= array ("key"=>"".$ar->idassociatedsequence,"value"=>$ar->associatedsequence);
            $result[] = $ln;
        }
        
        return $result;
    }
    public function suggestion($q) {
        $ar = AssociatedSequenceAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new AssociatedSequenceAR();
        $rs = array();

        $ar->associatedsequence = $field;
        $ar->idassociatedsequence = $id;


        if(isset($ar->idassociatedsequence)) {
            $returnAR = AssociatedSequenceAR::model()->findByPk($ar->idassociatedsequence);
        }else {
            $ar->associatedsequence = trim(addslashes($ar->associatedsequence));
            $returnAR = AssociatedSequenceAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->associatedsequence."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idassociatedsequence;
            $rs['field'] = $returnAR->associatedsequence;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($q) {
        $rs = array ();
        $ar = new AssociatedSequenceAR();
        $ar->associatedsequence = trim(addslashes($q));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idassociatedsequence == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idassociatedsequence;
            $rs['field'] = $rs['ar']->associatedsequence;
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
    public function getAssociatedSequenceByOccurrenceElement($ar) {
        $nnList = OccurrenceAssociatedSequenceAR::model()->findAll('idoccurrenceelement='.$ar->idoccurrenceelement);
        $associatedsequenceList = array();
        foreach ($nnList as $n=>$ar) {
            $associatedsequenceList[] = AssociatedSequenceAR::model()->findByPk($ar->idassociatedsequence);
        }
        return $associatedsequenceList;
    }
    public function saveOccurrenceElementNN($idAssociatedSequence,$idOccurrenceElement) {
        if(OccurrenceAssociatedSequenceAR::model()->find("idassociatedsequence=$idAssociatedSequence AND idoccurrenceelement=$idOccurrenceElement")==null) {
            $ar = OccurrenceAssociatedSequenceAR::model();
            $ar->idassociatedsequence = $idAssociatedSequence;
            $ar->idoccurrenceelement = $idOccurrenceElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteOccurrenceElementNN($idAssociatedSequence,$idOccurrenceElement) {
        $ar = OccurrenceAssociatedSequenceAR::model();
        $ar = $ar->find(" idassociatedsequence=$idAssociatedSequence AND idoccurrenceelement=$idOccurrenceElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteOccurrenceRecord($id){
        $ar = OccurrenceAssociatedSequenceAR::model();
        $arList = $ar->findAll(" idoccurrenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
    public function getAssociatedSequenceByCuratorialElement($ar) {
        $nnList = CuratorialAssociatedSequenceAR::model()->findAll('idcuratorialelement='.$ar->idcuratorialelement);
        $associatedsequenceList = array();
        foreach ($nnList as $n=>$ar) {
            $associatedsequenceList[] = AssociatedSequenceAR::model()->findByPk($ar->idassociatedsequence);
        }
        return $associatedsequenceList;
    }
    public function saveCuratorialElementNN($idAssociatedSequence,$idCuratorialElement) {
        if(CuratorialAssociatedSequenceAR::model()->find("idassociatedsequence=$idAssociatedSequence AND idcuratorialelement=$idCuratorialElement")==null) {
            $ar = CuratorialAssociatedSequenceAR::model();
            $ar->idassociatedsequence = $idAssociatedSequence;
            $ar->idcuratorialelement = $idCuratorialElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteCuratorialElementNN($idAssociatedSequence,$idCuratorialElement) {
        $ar = CuratorialAssociatedSequenceAR::model();
        $ar = $ar->find(" idassociatedsequence=$idAssociatedSequence AND idcuratorialelement=$idCuratorialElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteCuratorialRecord($id){
        $ar = CuratorialAssociatedSequenceAR::model();
        $arList = $ar->findAll(" idcuratorialelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
