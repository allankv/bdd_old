<?php

class IndividualLogic {

    var $mainAtt = 'individual';

    public function search($q) {
        $ar = IndividualAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        $ln = array("key" => "", "value" => $q . " <br>(New)</br>");
        $result[] = $ln;
        foreach ($rs as $n => $ar) {
            $ln = array("key" => "" . $ar->idindividual, "value" => $ar->individual);
            $result[] = $ln;
        }

        return $result;
    }

    public function suggestion($q) {
        $ar = IndividualAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }

    public function getJSON($field, $id) {

        $ar = new IndividualAR();
        $rs = array();

        $ar->individual = $field;
        $ar->idindividual = $id;

        if (isset($ar->idindividual)) {
            $returnAR = IndividualAR::model()->findByPk($ar->idindividual);
        } else {
            $ar->individual = trim(addslashes($ar->individual));
            $returnAR = IndividualAR::model()->find("UPPER($this->mainAtt)=UPPER('" . $ar->individual . "')");
        }

        if ($returnAR != null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idindividual;
            $rs['field'] = $returnAR->individual;
            $rs['ar'] = $returnAR->getAttributes();
        } else {
            $rs['success'] = false;
        }

        return $rs;
    }

    public function save($q) {
        $rs = array ();
        $ar = new IndividualAR();
        $ar->individual = trim(addslashes($q));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idindividual == null ? 'create' : 'update';
            $ar->setIsNewRecord($rs['operation'] == 'create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idindividual;
            $rs['field'] = $rs['ar']->individual;
            $rs['ar'] = $rs['ar']->getAttributes();

            return $rs;
        } else {
            $erros = array();
            foreach ($ar->getErrors() as $n => $mensagem):
                if ($mensagem[0] != "") {
                    $erros[] = $mensagem[0];
                }
            endforeach;
            $rs['success'] = false;
            $rs['msg'] = $erros;
            return $rs;
        }
    }

    public function getIndividualByOccurrenceElement($ar) {
        $nnList = OccurrenceIndividualAR::model()->findAll('idoccurrenceelement=' . $ar->idoccurrenceelement);
        $individualList = array();
        foreach ($nnList as $n) {
            $individualList[] = IndividualAR::model()->findByPk($n->idindividual);
        }
        return $individualList;
    }

    public function saveOccurrenceElementNN($idIndividual, $idOccurrenceElement) {
        if (OccurrenceIndividualAR::model()->find("idindividual=$idIndividual AND idoccurrenceelement=$idOccurrenceElement") == null) {
            $ar = OccurrenceIndividualAR::model();
            $ar->idindividual = $idIndividual;
            $ar->idoccurrenceelement = $idOccurrenceElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }

    public function deleteOccurrenceElementNN($idIndividual, $idOccurrenceElement) {
        $ar = OccurrenceIndividualAR::model();
        $ar = $ar->find(" idindividual=$idIndividual AND idoccurrenceelement=$idOccurrenceElement ");
        if ($ar != null) {
            $ar->delete();
        }
    }

    public function deleteOccurrenceRecord($id) {
        $ar = OccurrenceIndividualAR::model();
        $arList = $ar->findAll(" idoccurrenceelement=$id ");
        foreach ($arList as $n => $ar) {
            $ar->delete();
        }
    }

}

?>
