<?php
$home = array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Home'));
$about = array("url"=>array("route"=>"/about"),"label"=>Yii::t('yii','About'));
$manual = array("url"=>array("route"=>"/manual"),"label"=>Yii::t('yii','Manual'));
$tools = array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Tools'),
        array("url"=>array("route"=>"/specimen/goToList"),"label"=>Yii::t('yii','Specimens'),
                array("url"=>array("route"=>"/specimen/goToMaintain"),"label"=>Yii::t('yii','Create')),
                array("url"=>array("route"=>"/specimen/goToList"),"label"=>Yii::t('yii','List')),
                array("url"=>array("route"=>"/specimen/goToList"),"label"=>Yii::t('yii','Update')),
        //array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Provider'),
        //        array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','TAPIR')))
        ),
//        array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Species')),
        array("url"=>array("route"=>"/interaction/goToList"),"label"=>Yii::t('yii','Interaction'),
                array("url"=>array("route"=>"/interaction/goToMaintain"),"label"=>Yii::t('yii','Create')),
                array("url"=>array("route"=>"/interaction/goToList"),"label"=>Yii::t('yii','List')),
                array("url"=>array("route"=>"/interaction/goToList"),"label"=>Yii::t('yii','Update')),
        //array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Provider'),
        //        array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','TAPIR')))

        ),
        array("url"=>array("route"=>"/reference/goToList"),"label"=>Yii::t('yii','References'),
                array("url"=>array("route"=>"/reference/goToMaintain"),"label"=>Yii::t('yii','Create')),
                array("url"=>array("route"=>"/reference/goToList"),"label"=>Yii::t('yii','List')),
                array("url"=>array("route"=>"/reference/goToList"),"label"=>Yii::t('yii','Update')),
        //array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Provider'),
        //        array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','TAPIR')))

        ),
        array("url"=>array("route"=>"/media/goToList"),"label"=>Yii::t('yii','Media'),
                array("url"=>array("route"=>"/media/goToMaintain"),"label"=>Yii::t('yii','Create')),
                array("url"=>array("route"=>"/media/goToList"),"label"=>Yii::t('yii','List')),
                array("url"=>array("route"=>"/media/goToList"),"label"=>Yii::t('yii','Update')),
        //array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Provider'),
        //        array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','TAPIR')))
        ),
        
        //),
        //array("url"=>array("route"=>"/map&t=en_us"),"label"=>Yii::t('yii','Maps')),
        array("url"=>array("route"=>"/spreadsheetsync"),"label"=>Yii::t('yii','Spreadsheet Sync'),
        array("url"=>array("route"=>"/spreadsheetsync/import"),"label"=>Yii::t('yii','Import')),
        array("url"=>array("route"=>"/spreadsheetsync/export"),"label"=>Yii::t('yii','Export')),
        ),
        //array("url"=>array("route"=>"/georeferencingtool/apresentation"),"label"=>Yii::t('yii','BDD GeoTool'))
        ////,
//        array("url"=>array("route"=>"/"),"label"=>"Quality",
//                array("url"=>array("route"=>"/"),"label"=>"Data Cleaner"),
//                array("url"=>array("route"=>"/"),"label"=>"Georeferencer")
//       )
);
$download = array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Download'));
$standard = array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Standards'),
        array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Controlled vocabulary')),
        array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Interaction Schema')),
        array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Biodiversity informatics'))
);
$configuration = array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Configuration'),
        array("url"=>array("route"=>"/"),"label"=>Yii::t('yii','Users'))
);
if(Yii::app()->user->isGuest) {
    $menu = array($home, $about, $manual);
} else {
    $menu = array($home, $about, $tools, $manual);
}
$this->widget('application.extensions.menu.SMenu',
        array(
        "menu"=>$menu,
        "stylesheet"=>"menu_bdd.css",
        "menuID"=>"myMenu",
        "delay"=>1
        )
);
?>
