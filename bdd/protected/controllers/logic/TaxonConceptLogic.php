<?php
class TaxonConceptLogic {
    var $mainAtt = 'taxonconcept';
    public function search($q) {
        $ar = TaxonConceptAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtaxonconcept+"","label"=>$ar->taxonconcept,"value"=>$ar->taxonconcept);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TaxonConceptAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TaxonConceptAR();
        $rs = array();

        $ar->taxonconcept = $field;
        $ar->idtaxonconcept = $id;

        if(isset($ar->idtaxonconcept)) {
            $returnAR = TaxonConceptAR::model()->findByPk($ar->idtaxonconcept);
        }else {
            $ar->taxonconcept = trim($ar->taxonconcept);
            $returnAR = TaxonConceptAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->taxonconcept."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtaxonconcept;
            $rs['field'] = $returnAR->taxonconcept;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = TaxonConceptAR::model();
        $ar->taxonconcept = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtaxonconcept == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtaxonconcept;
            $rs['field'] = $rs['ar']->taxonconcept;
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
}
?>
