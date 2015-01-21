<?php

class LoadingfileController extends CController {
    public function actionGoToShow() {        
        $this->renderPartial('show',
                array_merge(array()
        ));
    }
}
