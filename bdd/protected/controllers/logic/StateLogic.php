<?php
class StateLogic {
    public function save($string) {
        $m = stateprovinces::model()->find('stateprovince=:c', array(':c'=>trim($string)));
        if(!isset($m) || $m->idstateprovince==null){
                $m = new stateprovinces();
                $m->stateprovince = $string;
                $m->save();
        }        
        return $m;
    }
}

?>
