
<?php 
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("css/lightbox.css");	
$cs->registerScriptFile("js/tablesorter/jquery.tablesorter.min.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/tablesorter/tablesorter.js",CClientScript::POS_HEAD);    
$cs->registerScriptFile("js/interaction.js",CClientScript::POS_END);       
?>

<table style="width:60%;margin:5px;margin-top:30px;margin-left:auto;margin-right:auto;">
    <tr>
        <td style="width:60px;text-align:center;"><?php echo CHtml::image("images/help/iconelist.png"); ?></td>
        <td style="width:auto;vertical-align:middle;"><h1><?php echo Yii::t('yii', 'List interaction records'); ?></h1></td>
    </tr>
</table>
<table style="width:60%;margin-bottom:15px;margin-left:auto;margin-right:auto;">
    <tr>
        <td style="width:10px"></td>
        <td style="width:auto;vertical-align:middle;"><?php echo Yii::t('yii', 'Use this tool to search through all interaction records in the BDD database and view, edit or delete any of them. To begin your search, specify at least the Institution Code and the Collection Code of one of the interacting specimen. Optionally, you may narrow your search by indicating the specimen record’s Basis of Record, the specimen’s Scientific Name, and the Interaction Type.'); ?></td>
    </tr>
</table>

<?php echo CHtml::beginForm(); ?>

<?php 	

if($exibeControle) {
    ?>

    <?php

    //Gerenciar mensagens para o usuario

    if($_POST["msgType"]!="")
        $msgType = $_POST["msgType"];
    else
        $msgType = $_GET["msgType"];

    switch($msgType) {
        case "successDelete":
            echo "<div class='success'>";
            echo "<h2>".Yii::t('yii', 'Success deleted!')."</h2>";
            echo "</div>";
            break;
    }

    ?>

<br>    

    <?php echo CHtml::hiddenField('ctrForm','filtros'); ?>

<div class="yiiForm">

    <table cellspacing="0" cellpadding="0" align="center" class="tablelist">
        <tr>
            <td class="tablelabelcel"><?php echo CHtml::label(Yii::t('yii','Institution code'), "recordlevelelements"); ?></td>
            <td class="tablemiddlecel"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=institutioncode',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></td>
            <td class="tablefieldcel">
                    <?php if($idinstitutioncode!="") {
                        echo CHtml::dropDownList('institutionCode',$idinstitutioncode,CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('collectionCode','')"));
                    }else {
                        echo CHtml::dropDownList('institutionCode',$idinstitutioncode,CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('collectionCode','')"));
                    }
                    ?>
            </td>
            <td class="tableundocel">
                <div style="display:none;" id='div-institutionCodeUndo' >
                    <a href="javascript:habilitaDropDownList('institutionCode','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                    &nbsp;</div>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel"><?php echo CHtml::label(Yii::t('yii',"Collection code"),'collectionCode'); ?></td>
            <td class="tablemiddlecel"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collectioncode',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></td>
            <td class="tablefieldcel"><?php echo CHtml::dropDownList('collectionCode',$idcollectioncode,CHtml::listData(collectioncodes::model()->findAll(" 1=1 ORDER BY collectioncode "), 'idcollectioncode', 'collectioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('basisOfRecord','')"));?></td>
            <td class="tableundocel">
                <div style="<?php if(($idcollectioncode!="")&&($idscientificname=="")&&($idbasisofrecord=="")&&($idinteractiontype=="")) echo "display:inline"; else echo "display:none";?>" id='div-collectionCodeUndo' >
                    <a href="javascript:habilitaDropDownList('collectionCode','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
                &nbsp;</td>
        </tr>

        <tr>
            <td class="tablelabelcel"><?php echo CHtml::label(Yii::t('yii',"Basis of record"),'basisOfRecord'); ?></td>
            <td class="tablemiddlecel"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=basisofrecord',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></td>
            <td class="tablefieldcel">
                    <?php
                    if(($idinteractiontype=="")&&($idbasisofrecord=="")&&($idscientificname=="")&&($idcollectioncode!="")&&($idinstitutioncode!="")) {
                        echo CHtml::dropDownList('basisOfRecord',$idbasisofrecord,CHtml::listData(basisofrecords::model()->findAll(" 1=2  "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('scientificName','')"));
                        ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        requisitaValoresDropDownList("basisOfRecord","");
                    })
                </script>
                        <?php
                    }else {
                    
                    	if($idbasisofrecord!=""){                    
                        	echo CHtml::dropDownList('basisOfRecord',$idbasisofrecord,CHtml::listData(basisofrecords::model()->findAll(" 1=1 AND idbasisofrecord = ".$idbasisofrecord." "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('scientificName','')"));
                    	}else{
                    		echo CHtml::dropDownList('basisOfRecord',$idbasisofrecord,CHtml::listData(basisofrecords::model()->findAll(" 1=2  "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('scientificName','')"));
                    	}
                    }
                    ?>
            </td>
            <td class="tableundocel">
                <div style="<?php if(($idbasisofrecord!="")&&($idinteractiontype=="")) echo "display:inline"; else echo "display:none";?>" id='div-basisOfRecordUndo' >
                    <a href="javascript:habilitaDropDownList('basisOfRecord','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
                &nbsp;</td>
        </tr>        

        <tr>
            <td class="tablelabelcel"><?php echo CHtml::label(Yii::t('yii',"Scientific name"),'scientificName'); ?></td>
            <td class="tablemiddlecel"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></td>
            <td class="tablefieldcel">
                    <?php
                    if(($idinteractiontype=="")&&($idbasisofrecord!="")&&($idscientificname=="")&&($idcollectioncode!="")&&($idinstitutioncode!="")) {
                        echo CHtml::dropDownList('scientificName',$idscientificname,CHtml::listData(scientificnames::model()->findAll(" 1=2  "), 'idscientificname', 'scientificname'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('interactionType','')"));
                        ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        requisitaValoresDropDownList("scientificName","");
                    })
                </script>
                        <?php
                    }else {
                    	
                    	if($idscientificname!=""){
                    	
							echo CHtml::dropDownList('scientificName',$idscientificname,CHtml::listData(scientificnames::model()->findAll(" 1=1 AND idscientificname = ".$idscientificname." "), 'idscientificname', 'scientificname'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('interactionType','')"));                    	
                    	
                    	}else{
                    	
                    		echo CHtml::dropDownList('scientificName',$idscientificname,CHtml::listData(scientificnames::model()->findAll(" 1=2 "), 'idscientificname', 'scientificname'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('interactionType','')"));
                    	}
                    
                        
                    }
                    ?>
            </td>
            <td class="tableundocel">
                <div style="<?php if(($idscientificname!="")&&($idbasisofrecord=="")&&($idinteractiontype=="")) echo "display:inline"; else echo "display:none";?>" id='div-scientificNameUndo' >
                    <a href="javascript:habilitaDropDownList('scientificName','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
                &nbsp;</td>
        </tr>
        <tr>
            <td class="tablelabelcel"><?php echo CHtml::label(Yii::t('yii',"Interaction type"),'interactionType'); ?></td>
            <td class="tablemiddlecel"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=interactiontype',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></td>
            <td class="tablefieldcel">
                    <?php
                    if(($idinteractiontype=="")&&($idbasisofrecord!="")&&($idscientificname!="")&&($idcollectioncode!="")&&($idinstitutioncode!="")) {
                        echo CHtml::dropDownList('interactionType',$idinteractiontype,CHtml::listData(interactiontypes::model()->findAll(" 1=2  "), 'idinteractiontype', 'interactiontype'), array('empty'=>'-','onChange'=>"exibeRespostaBusca()"));
                        ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        requisitaValoresDropDownList("interactionType","");
                    })
                </script>
                        <?php
                    }else {
                    	
                    	if($idinteractiontype!=""){                    
                        	echo CHtml::dropDownList('interactionType',$idinteractiontype,CHtml::listData(interactiontypes::model()->findAll(" 1=1 WHERE interactiontype = ".$idinteractiontype." "), 'idinteractiontype', 'interactiontype'), array('empty'=>'-','disabled'=>'','onChange'=>"exibeRespostaBusca()"));
                    	}else{
                    		echo CHtml::dropDownList('interactionType',$idinteractiontype,CHtml::listData(interactiontypes::model()->findAll(" 1=2 "), 'idinteractiontype', 'interactiontype'), array('empty'=>'-','disabled'=>'','onChange'=>"exibeRespostaBusca()"));
                    	}
                    }
                    ?>
            </td>
            <td class="tableundocel">
                <div style="<?php if($idinteractiontype!="") echo "display:inline"; else echo "display:none";?>" id='div-interactionTypeUndo' >
                    <a href="javascript:habilitaDropDownList('interactionType','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
                &nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top:15px;text-align:right;">
                <div style="margin-left: auto;margin-right: auto;text-align:right;">
                        <?php
                        if(($idbasisofrecord=="")||($idscientificname=="")||($idinteractiontype=="")) {
                            echo CHtml::submitButton(Yii::t('yii','Search'), array("onclick"=>"exibeRespostaBusca('recordlevelelements/list');",'disabled'=>'','id'=>'botaoSearch'));
                        }else {
                        	
                            echo CHtml::submitButton(Yii::t('yii','Search'), array("onclick"=>"exibeRespostaBusca('recordlevelelements/list');",'id'=>'botaoSearch'));
                        }
                        ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;">
                <div style="margin-top:15px;margin-left: auto;margin-right: auto;text-align:right;">
                    [ <?php echo CHtml::link(CHtml::image("images/main/ic_mais.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii', "Create a new Interaction record"), array('create')); ?>&nbsp;&nbsp;]</div>
            </td>
        </tr>
    </table>
</div>


    <?php } ?>

<?php if($interactionelementsList !== null) { ?>

	<div style="margin-bottom:20px;margin-top:30px;width:80%;margin-left:auto;margin-right:auto;height:1px;background-color:#cccccc;"></div>

<div class="item" style="width:100%;">

        <?php
        if (count($interactionelementsList)<1) {
            echo "<center>".Yii::t('yii', "No records found")."</center>";
        }else {

            ?>

    <div class="foundbar">
                <?php echo Yii::t('yii','Interaction elements found').": <font style=\"font-size:14px;font-weight:bold;\">".$totalRegistros."</font>"; ?>
    </div>            

    <table id="tablelist" class="list">
        <thead>
            <tr>
                <th></th>
                <th colspan="2" style="text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Specimen 1')); ?></th>
                <th rowspan="2" style="width:120px;text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Interaction Type')); ?></th>
                <th colspan="2" style="text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Specimen 2')); ?></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th style="text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Taxonomic Element')); ?></th>
                <th style="width:60px;text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Catalog Number')); ?></th>
                <th style="text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Taxonomic Element')); ?></th>
                <th style="width:60px;text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Catalog Number')); ?></th>
                <th style="width:50px;"></th>
            </tr>
        </thead>

        <tbody>
                    <?php foreach($interactionelementsList as $n=>$model):?>
                        <?php $idinteractionelement = $model->idinteractionelements;?>
            <tr <?php if($interactionelements->getAttribute("idinteractionelements")==$model->idinteractionelements) { echo "style=\"background-color: #ADCEFF;\""; } ?>>
                <td style="width:20px;text-indent:0;">               	
                	
                   <?php if($model->isrestricted) echo CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;","title"=>Yii::t('yii','Private')));?>
                </td>
                <td style="padding-left:6px;">
                    <?php echo WebbeeController::lastTaxa($recordlevelelements->findByPk($model->idspecimens1)); ?>
                </td>
                <td style="text-align:center;">
                   <?php echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->catalognumber); ?>
                </td>
                <td style="text-align:center;">
                    <?php echo CHtml::encode($interactiontypes->findByPk($model->idinteractiontype)->interactiontype); ?>
                </td>
                <td style="padding-left:6px;">
                    <?php echo WebbeeController::lastTaxa($recordlevelelements->findByPk($model->idspecimens2)); ?>
                </td>
                <td style="text-align:center;">
                    <?php  echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->catalognumber);?>
                </td>
                <td style="text-align:center;">
                                <?php //echo CHtml::link(CHtml::image("images/main/ico_buscar.gif", "",array("style"=>"border:0px;")),array('show',''))." | "; ?>
                                <?php
                                if($idrecordlevelelement!="") {
                                    echo CHtml::link(CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Update'))),array('specimenInteraction','id'=>$idinteractionelement,'idrecordlevelelement'=>$idrecordlevelelement,'idinstitutioncode'=>$_GET['idinstitutioncode'], 'idcollectioncode'=>$_GET['idcollectioncode'], 'catalognumber'=>$_GET['catalognumber'], 'idscientificname'=>$_GET['idscientificname'], 'scientificnamevalue'=>$_GET['scientificnamevalue']));
                                }else {
                                    echo CHtml::link(CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Update'))),array('update','id'=>$idinteractionelement,'idinstitutioncode'=>$_GET['idinstitutioncode'], 'idcollectioncode'=>$_GET['idcollectioncode'], 'idbasisofrecord'=>$_GET['idbasisofrecord'], 'idscientificname'=>$_GET['idscientificname'], 'idinteractiontype'=>$_GET['idinteractiontype']));
                                }
                                ?>
                                <?php
                                if($idrecordlevelelement!="") {
                                    echo "|".CHtml::linkButton(CHtml::image("images/main/canc.gif", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Delete'))),array('submit'=>array('delete','class'=>'confirm','id'=>$idinteractionelement,'institutionCode'=>$idinstitutioncode,'collectionCode'=>$idcollectioncode,'scientificName'=>$idscientificname,'basisOfRecord'=>$idbasisofrecord,'interactionType'=>$idinteractiontype,'idrecordlevelelement'=>$idrecordlevelelement,'idinstitutioncode'=>$_GET['idinstitutioncode'], 'idcollectioncode'=>$_GET['idcollectioncode'], 'catalognumber'=>$_GET['catalognumber'], 'idscientificname'=>$_GET['idscientificname'], 'scientificnamevalue'=>$_GET['scientificnamevalue']),'confirm'=>Yii::t('yii', 'Are you sure to delete?')));
                                }else {
                                    echo "|".CHtml::linkButton(CHtml::image("images/main/canc.gif", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Delete'))),array('submit'=>array('delete','class'=>'confirm','id'=>$idinteractionelement,'institutionCode'=>$idinstitutioncode,'collectionCode'=>$idcollectioncode,'scientificName'=>$idscientificname,'basisOfRecord'=>$idbasisofrecord,'interactionType'=>$idinteractiontype),'confirm'=>Yii::t('yii', 'Are you sure to delete?')));
                                }
                                ?>
                </td>
            </tr>
                    <?php endforeach; ?>
        </tbody>
    </table>
</div>
        <?php
    }?>

<div style="width:75%;margin-top:10px;margin-bottom:10px;margin-left: auto;margin-right:auto;text-align:right;"><?php $this->widget('CLinkPager',array('pages'=>$pages)); ?></div>

<div style="-moz-border-radius-topleft: 0.4em; -moz-border-radius-topright: 0.4em; -moz-border-radius-bottomleft: 0.4em; -moz-border-radius-bottomright: 0.4em;vertical-align:middle;padding:5px;padding-left:25px;width:77%;margin-left:auto;margin-right:auto;background-color:#eeeeee;margin-bottom:5px;margin-top:20px;">
        <?php echo CHtml::image("images/main/ico_buscar.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Show')."&nbsp; | &nbsp;&nbsp;"; ?>
        <?php echo CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Update')."&nbsp; | &nbsp;&nbsp;"; ?>
        <?php echo CHtml::image("images/main/canc.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Delete')."&nbsp; | &nbsp;&nbsp;"; ?>
        <?php echo CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Is Private'); ?>
</div>

    <?php
}
?>

<?php echo CHtml::endForm(); ?>

<br/><br/>

