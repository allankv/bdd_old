<?php
class TagLogic {
    var $mainAtt = 'tag';
    public function search($q) {
        $ar = TagAR::model();
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
            $ln= array ("key"=>"".$ar->idtag,"value"=>$ar->tag);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TagAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TagAR();
        $rs = array();

        $ar->tag = $field;
        $ar->idtag = $id;

        if(isset($ar->idtag)) {
            $returnAR = TagAR::model()->findByPk($ar->idtag);
        }else {
            $ar->tag = trim($ar->tag);
            $returnAR = TagAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->tag."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtag;
            $rs['field'] = $returnAR->tag;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = TagAR::model();
        $ar->tag = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtag == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtag;
            $rs['field'] = $rs['ar']->tag;
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
    public function getTagByMedia($ar) {
        $nnList = MediaTagAR::model()->findAll('idmedia='.$ar->idmedia);
        $tagList = array();
        foreach ($nnList as $n=>$ar) {
            $tagList[] = TagAR::model()->findByPk($ar->idtag);
        }
        return $tagList;
    }
    public function saveMediaNN($idTag,$idMedia) {
        if(MediaTagAR::model()->find("idtag=$idTag AND idmedia=$idMedia")==null) {
            $ar = MediaTagAR::model();
            $ar->idtag = $idTag;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idTag,$idMedia) {
        $ar = MediaTagAR::model();
        $ar = $ar->find(" idtag=$idTag AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaTagAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
