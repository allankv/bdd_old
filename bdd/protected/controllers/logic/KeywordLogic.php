<?php
class KeywordLogic {
    var $mainAtt = 'keyword';
    public function searchList($q) {
        $ar = KeywordAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = KeywordAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();
        $ln= array ("key"=>"","value"=>$q." <br>(New)</br>");
            $result[] = $ln;
        foreach ($rs as $n=>$ar) {
            $ln= array ("key"=>"".$ar->idkeyword,"value"=>$ar->keyword);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = KeywordAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new KeywordAR();
        $rs = array();

        $ar->keyword = $field;
        $ar->idkeyword = $id;

        if(isset($ar->idkeyword)) {
            $returnAR = KeywordAR::model()->findByPk($ar->idkeyword);
        }else {
            $ar->keyword = trim($ar->keyword);
            $returnAR = KeywordAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->keyword."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idkeyword;
            $rs['field'] = $returnAR->keyword;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = KeywordAR::model();
        $ar->keyword = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idkeyword == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idkeyword;
            $rs['field'] = $rs['ar']->keyword;
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
    public function getKeywordByMedia($ar) {
        $nnList = MediaKeywordAR::model()->findAll('idmedia='.$ar->idmedia);
        $keywordList = array();
        foreach ($nnList as $n=>$ar) {
            $keywordList[] = KeywordAR::model()->findByPk($ar->idkeyword);
        }
        return $keywordList;
    }
    public function saveMediaNN($idKeyword,$idMedia) {
        if(MediaKeywordAR::model()->find("idkeyword=$idKeyword AND idmedia=$idMedia")==null) {
            $ar = MediaKeywordAR::model();
            $ar->idkeyword = $idKeyword;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idKeyword,$idMedia) {
        $ar = MediaKeywordAR::model();
        $ar = $ar->find(" idkeyword=$idKeyword AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaKeywordAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getKeywordByReference($ar) {
        $nnList = ReferenceKeywordAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $keywordList = array();
        foreach ($nnList as $n=>$ar) {
            $keywordList[] = KeywordAR::model()->findByPk($ar->idkeyword);
        }
        return $keywordList;
    }
    public function saveReferenceNN($idKeyword,$idReference) {
        if(ReferenceKeywordAR::model()->find("idkeyword=$idKeyword AND idreferenceelement=$idReference")==null) {
            $ar = ReferenceKeywordAR::model();
            $ar->idkeyword = $idKeyword;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idKeyword,$idReference) {
        $ar = ReferenceKeywordAR::model();
        $ar = $ar->find(" idkeyword=$idKeyword AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferenceKeywordAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getKeywordBySpecies($ar) {
        $nnList = SpeciesKeywordAR::model()->findAll('idspecies='.$ar->idspecies);
        $keywordList = array();
        foreach ($nnList as $n=>$ar) {
            $keywordList[] = KeywordAR::model()->findByPk($ar->idkeyword);
        }
        return $keywordList;
    }
    public function saveSpeciesNN($idKeyword,$idSpecies) {
        if(SpeciesKeywordAR::model()->find("idkeyword=$idKeyword AND idspecies=$idSpecies")==null) {
            $ar = SpeciesKeywordAR::model();
            $ar->idkeyword = $idKeyword;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idKeyword,$idSpecies) {
        $ar = SpeciesKeywordAR::model();
        $ar = $ar->find(" idkeyword=$idKeyword AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesKeywordAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
