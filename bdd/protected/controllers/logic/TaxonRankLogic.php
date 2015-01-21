<?php
class TaxonRankLogic {
    var $mainAtt = 'taxonrank';
    public function search($q) {
        $ar = TaxonRankAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtaxonrank+"","label"=>$ar->taxonrank,"value"=>$ar->taxonrank);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TaxonRankAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TaxonRankAR();
        $rs = array();

        $ar->taxonrank = $field;
        $ar->idtaxonrank = $id;

        if(isset($ar->idtaxonrank)) {
            $returnAR = TaxonRankAR::model()->findByPk($ar->idtaxonrank);
        }else {
            $ar->taxonrank = trim($ar->taxonrank);
            $returnAR = TaxonRankAR::model()->find("$this->mainAtt='".$ar->taxonrank."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtaxonrank;
            $rs['field'] = $returnAR->taxonrank;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {

        $rs = array ();
        $ar = TaxonRankAR::model();
        $ar->taxonrank = trim($field);

        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtaxonrank == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;
            
            return $rs;
        }
        else {
            $erros = array();
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
