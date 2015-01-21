<?php
$cs=Yii::app()->clientScript;
//Light box
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("css/lightbox.css");
$cs->registerScriptFile("js/lightbox/recordlevelelements.js",CClientScript::POS_HEAD);
//Sorter
$cs->registerScriptFile("js/tablesorter/jquery.tablesorter.min.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/tablesorter/tablesorter.js",CClientScript::POS_HEAD);
//Load autocompletefields
//$cs->registerScriptFile("js/autocomplete.js",CClientScript::POS_END);
//$cs->registerScriptFile("js/loadfields.js",CClientScript::POS_END);
//ActionDelete
$cs->registerScriptFile("js/deleteelements.js",CClientScript::POS_END);

$cs->registerScriptFile("js/recordlevelelements.js",CClientScript::POS_END);
?>

<link href="js/jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="js/jquery/jquery.min.js"></script>
<script src="js/jquery/jquery-ui.min.js"></script>
<style type="text/css">
    #slider { margin: 10px; }
</style>
<script>    
    function search(limit, offset){        
        $.ajax({ url: "index.php?r=recordlevelelements/getCount",type: "POST",
            data: "offset="+offset+"&limit="+limit+"&idinstitutioncode="+$('#recordlevelelements_idinstitutioncode').val(),
            success: function(data){
                slider(data);
            }});
        filter(limit, offset);
    }
    function filter(limit, offset){        
        $('#rs').load('index.php?r=recordlevelelements/filterList #result', 
        {'limit':limit,'offset':offset, 'idinstitutioncode':$('#recordlevelelements_idinstitutioncode').val()});
    }

    function slider(maxValue){        
        $("#slider").slider({
            range: true,
            min: 0,
            max: maxValue,
            values: [0, 10],
            slide: function(event, ui) {
                filter((ui.values[1]-ui.values[0]),ui.values[0]);                
            }
        });
    }
    $(document).ready(function() {

    });
</script>

<table style="width:60%;margin:5px;margin-top:30px;margin-left:auto;margin-right:auto;">
    <tr>
        <td style="width:60px;text-align:center;"><?php echo CHtml::image("images/help/iconelist.png"); ?></td>
        <td style="width:auto;vertical-align:middle;"><h1><?php echo Yii::t('yii', 'List specimen records'); ?></h1></td>
    </tr>
</table>
<table style="width:60%;margin-bottom:15px;margin-left:auto;margin-right:auto;">
    <tr>
        <td style="width:10px"></td>
        <td style="width:auto;vertical-align:middle;"><?php echo Yii::t('yii', 'Use this tool to search through all specimen records in the BDD database and edit or delete any of them. Moreover, this tool includes quick links to create and edit links between existing Specimen Records and one or more Interaction, Reference, and Media Records.'); ?></td>
    </tr>
</table>

<?php echo CHtml::beginForm(); ?>

<div class="yiiForm">    
    <table cellspacing="0" cellpadding="0" align="center" class="tablelist">
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Institution code'), "recordlevelelements",""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=institutioncode',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?>
            </td>
            <td class="tablefieldcel">
                <?php
                if($recordlevelelements->idinstitutioncode!="") {
                    echo CHtml::activeDropDownList($recordlevelelements, 'idinstitutioncode', CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('recordlevelelements_idcollectioncode')"));
                }else {
                    echo CHtml::activeDropDownList($recordlevelelements, 'idinstitutioncode', CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('recordlevelelements_idcollectioncode')"));
                }
                ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">
                <div  style="display: none" id='div-recordlevelelements_idinstitutioncodeUndo' >
                    <a href="javascript:habilitaDropDownList('recordlevelelements_idinstitutioncode','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
                &nbsp;
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Collection code'), "recordlevelelements",""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collectioncode',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeDropDownList($recordlevelelements, 'idcollectioncode', CHtml::listData(collectioncodes::model()->findAll(" 1=1 ORDER BY collectioncode "), 'idcollectioncode', 'collectioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('taxonomicelements_idscientificname')")); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">
                <div  style="<?php if(($recordlevelelements->idcollectioncode!="")&&($taxonomicelements->scientificname=="")&&($occurrenceelements->catalognumber=="")) echo "display:block"; else echo "display:none";?>" id='div-recordlevelelements_idcollectioncodeUndo' >
                    <a href="javascript:habilitaDropDownList('recordlevelelements_idcollectioncode','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii', 'Scientific name'), "taxonomicelements",""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?>
            </td>
            <td class="tablefieldcel">            
                <?php

                if(($recordlevelelements->idcollectioncode!="")&&($taxonomicelements->scientificname=="")&&($occurrenceelements->catalognumber=="")) {

                    echo CHtml::activeDropDownList($taxonomicelements, 'idscientificname', CHtml::listData(scientificnames::model()->findAll(" 1=1 order by scientificname "), 'idscientificname', 'scientificname'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('occurrenceelements_catalognumber')"));

                    ?>
                <script >
                    $(document).ready(function(){
                        requisitaValoresDropDownList("taxonomicelements_idscientificname");
                    })
                </script>

                    <?php

                }else {

                    if($taxonomicelements->scientificname!="") {
                        echo CHtml::activeDropDownList($taxonomicelements, 'idscientificname', CHtml::listData(scientificnames::model()->findAll(" 1=1 AND idscientificname = ".$taxonomicelements->scientificname->idscientificname."   "), 'idscientificname', 'scientificname'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('occurrenceelements_catalognumber')"));
                    }else {
                        echo CHtml::activeDropDownList($taxonomicelements, 'idscientificname', CHtml::listData(scientificnames::model()->findAll(" 1=2  "), 'idscientificname', 'scientificname'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('occurrenceelements_catalognumber')"));
                    }

                }
                ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">
                <div  style="<?php if(($taxonomicelements->scientificname!="")&&($occurrenceelements->catalognumber=="")) echo "display:block"; else echo "display:none";?>" id='div-taxonomicelements_idscientificnameUndo' >
                    <a href="javascript:habilitaDropDownList('taxonomicelements_idscientificname','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Catalog number'), "occurrenceelements",""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=catalognumber',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?>
            </td>
            <td class="tablefieldcel">
                <?php
                if(($occurrenceelements->catalognumber=="")&&($taxonomicelements->scientificname!="")) {
                    echo CHtml::activeDropDownList($occurrenceelements, 'catalognumber', CHtml::listData(occurrenceelements::model()->findAll(" 1=2  "), 'catalognumber', 'catalognumber'), array('empty'=>'-','onChange'=>"exibeRespostaBusca('recordlevelelements/list')"));
                    ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        requisitaValoresDropDownList("occurrenceelements_catalognumber");
                    })
                </script>

                    <?php
                }else {

                    if($occurrenceelements->catalognumber!="") {
                        echo CHtml::activeDropDownList($occurrenceelements, 'catalognumber', CHtml::listData(occurrenceelements::model()->findAll(" 1=1 AND catalognumber = '".$occurrenceelements->catalognumber."'  "), 'catalognumber', 'catalognumber'), array('empty'=>'-','disabled'=>'','onChange'=>"exibeRespostaBusca('recordlevelelements/list')"));
                    }else {
                        echo CHtml::activeDropDownList($occurrenceelements, 'catalognumber', CHtml::listData(occurrenceelements::model()->findAll(" 1=2  "), 'catalognumber', 'catalognumber'), array('empty'=>'-','disabled'=>'','onChange'=>"exibeRespostaBusca('recordlevelelements/list')"));
                    }
                }
                ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">
                <div  style="<?php if($occurrenceelements->catalognumber!="") echo "display:block"; else echo "display:none";?>" id='div-occurrenceelements_catalognumberUndo' >
                    <a href="javascript:habilitaDropDownList('occurrenceelements_catalognumber','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top:15px;text-align:right;">
                <div style="margin-left: auto;margin-right: auto;text-align:right;">
                    <?php
                    //if(($occurrenceelements->catalognumber=="")&&($taxonomicelements->scientificname!="")) {
                    //echo CHtml::submitButton(Yii::t('yii','Search'), array("onclick"=>"exibeRespostaBusca('recordlevelelements/list');",'id'=>'botaoSearch'));
                    echo CHtml::button(Yii::t('yii','Search'),array("onclick"=>"search(10,0);"));
                    //}else {
                    //echo CHtml::submitButton(Yii::t('yii','Search'), array("onclick"=>"exibeRespostaBusca('recordlevelelements/list');",'disabled'=>'','id'=>'botaoSearch'));
                    //    echo CHtml::ajaxButton(Yii::t('yii','Search'), CController::createUrl('recordlevelelements/list'),array("update"=>"#tablelist",'id'=>'botaoSearch'));
                    //}
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;">
                <div style="margin-top:15px;margin-left: auto;margin-right: auto;text-align:right;">
                    [ <?php echo CHtml::link(CHtml::image("images/main/ic_mais.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii', "Create a new Specimen record"), array('create')); ?>&nbsp;&nbsp;]</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;">
                <label for="valueslide"></label> <div id="slider"></div>
            </td>
        </tr>
    </table>
</div>

<?php

echo CHtml::endForm(); ?>
<div id="rs"></div>

<?php //}?>

<br/><br/>

