<?php
class ContinentLogic {
    var $mainAtt = 'continent';
    public function getContinent($ar) {
        if(isset($ar->idcontinent)){
            return ContinentAR::model()->findByPk($ar->idcontinent);
        }else{
            $ar->continent = trim($ar->continent);
            return ContinentAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->continent."')");
        }    
    }
    public function save($ar) {
        $rs = array ();
        $ar->continent = trim($ar->continent);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcontinent == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;
            return $rs;
        }else{
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
