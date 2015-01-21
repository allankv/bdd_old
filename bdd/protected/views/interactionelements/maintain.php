<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/List.js",CClientScript::POS_END);
?>
<link href="js/jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/tablesorter/themes/blue/style.css" />
<script src="js/jquery/jquery.min.js"></script>
<script src="js/jquery/jquery-ui.min.js"></script>
<style type="text/css">
    #slider { margin: 10px; }
</style>
<style>
    .ui-autocomplete-category {
        font-weight: bold;
        padding: .2em .4em;
        margin: .8em 0 .2em;
        line-height: 1.5;
    }
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
</style>
<script>
    var start = 0;
    var end = 10;
    var max = 0;   
    $(document).ready(bootSpecimen);
    // Inicia configuracoes Javascript
    function bootSpecimen(){
        configCatComplete('#id','#searchField', 'specimen','#filterList');
        filter();
        slider();
    }
    function filter(){
        $.ajax({ type:'POST',
            url:'index.php?r=specimen/filter',
            data: {'limit':(end-start),'offset':start,'list':jFilterList},
            dataType: "json",
            success:function(json) {
                var rs = new Object();
                $("#lines").html('');
                max = parseInt(json.count);
                $( "#slider" ).slider({ max: max });
                $('#start').html(start>max?0:start);
                $('#end').html(end>max?max:end);
                $('#max').html(max);

                rs = json.result;
                for(var i in rs){
                    insertLine(rs[i]);
                }
            }
        });
    }
    function insertLine(rs){
        var line ='<tr id="gui__ID_"><td style="width:20px;text-indent:0;">_ISPRIVATE_</td><td>_LASTTAXA_</td><td style="width:120px;text-align:center;">_CATALOGNUMBER_</td><td style="width:160px;text-align:center;text-indent:0px;">_BUTTONS_</td></tr>';
        var aux = line;
        aux = aux.replace('_ID_',rs.id);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?'<img src="images/main/private.gif"/>':'');
        aux = aux.replace('_LASTTAXA_',rs.scientificname);
        aux = aux.replace('_CATALOGNUMBER_',rs.catalognumber);

        var btnEdit = '<a href="#"><img src="images/main/edit.png" style="border:0px;" title="Update"/></a> | ';
        var btnReference = '<a href="#"><img src="images/main/doc.png" style="border:0px;" title="References"/></a> | ';
        var btnMedia = '<a href="#"><img src="images/main/images.gif" style="border:0px;" title="Medias"/></a> | ';
        var btnInteraction = '<a href="#"><img src="images/main/ic_alvo.gif" style="border:0px;" title="Interaction"/></a> | ';
        var btnDelete = '<a href="#" onclick="alert(\'Delete '+rs.id+'\');"><img src="images/main/canc.gif" style="border:0px;" title="Delete"/></a> | ';
        aux = aux.replace('_BUTTONS_',btnEdit+btnReference+btnMedia+btnInteraction+btnDelete);

        $("#lines").append(aux);
    }
    function slider(){
        $("#slider").slider({
            range: true,
            min: 0,
            max: max,
            values: [0, 10],
            stop: function(event, ui) {
                start = ui.values[0];
                end = ui.values[1];
                filter();
            }
        });
    }
</script>
<?php echo CHtml::beginForm();?>
<!-- Texto Introdutorio-->
<div style="width:80%;margin-top:30px;margin-left:auto;margin-right: auto;">
    <h1 style="margin:0px;"><?php echo Yii::t('yii','Create a new interaction record'); ?> </h1>
    <p class="tooltext"><?php echo Yii::t('yii','Use this tool to save information regarding the relationship between two occurrence records in the database. To expedite the process, use the search fields to find the specimen records whose interaction you wish to record and specify the Interaction type.'); ?></p>
</div>
<div class="yiiForm" style="width:80%;">
    <!-- Specimen -->
    <div class="tablerequired" style="width:98%;padding:8px;margin-bottom:5px;letter-spacing:1.5px;font-weight:bold;font-size:12px;text-indent:7px;">
        <?php echo CHtml::encode(Yii::t('yii','Specimen')); ?> 1
    </div>
    <div id='divFiltros'> <!-- Igual ao Specimen List -->
        <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable" style="background-color:#f7f7f7;">
            <tr>
                <td style="vertical-align:top;">
                    <table cellspacing="0" cellpadding="0" align="center" class="tablelist">
                        <tr>
                            <td class="tablelabelcel">
                                <?php echo 'Filter '; //traduzir ?>
                            </td>
                            <td class="tablemiddlecel">
                                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=filter',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?>
                            </td>
                            <td class="tablefieldcel">
                                <input type="text" id="searchField" style="border: 1px solid #89aa95;background: #EFFFEF;color: #013605;font-size: 1.3em;" />
                                <input type="hidden" id="id"/>
                            </td>
                            <td class="tableautocel">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="tablelabelcel">
                                <?php echo ' ';?>
                            </td>
                            <td class="tablemiddlecel">
                                <?php echo ' ';?>
                            </td>
                            <td class="tablefieldcel">
                                <ul id="filterList">
                                </ul>
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" align="center" class="tablelist">
                        <tr>
                            <td class="tablelabelcel">
                                Filtered from <b><span id="start"/></b> to <b><span id="end"/></b> of <b><span id="max"/></b>
                            </td>                                                        
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right;">
                                <label for="valueslide"></label> <div id="slider"></div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:430px;background-color:#f0f0f0;vertical-align:top;-moz-border-radius-topleft: 1em;-moz-border-radius-topright: 1em;-moz-border-radius-bottomleft: 1em;-moz-border-radius-bottomright: 1em;border:1px solid #f3f3f3;">
                    <div id="rs" class="item">
                        <div style="margin-bottom:20px;margin-top:30px;width:80%;margin-left:auto;margin-right:auto;height:1px;background-color:#cccccc;"></div>
                        <table id="tablelist" class="list">
                            <thead>
                                <tr>
                                    <th>   </th> <th>Taxonomic elements</th> <th style="text-align:center;">Catalog number</th> <th>Options</th>
                                </tr>
                            </thead>
                            <tbody id="lines">
                            <tbody>
                        </table>
                        <br/>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <!-- Selected Specimen1 -->
    <div id='divSpecimenSelecionada1' class='change'>
        <table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" style=\"background-color:transparent;\">
            <tr>
                <td rowspan=\"2\" style=\"font-weight:bold;width:100px;text-align:left;\">
                    <a href=\"javascript:ativaFiltrosSpecimen(1);\"><?php echo CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Update')))?></a>
                    <a href=\"javascript:ativaFiltrosSpecimen(1);\"><?php echo Yii::t('yii',"Change")?></a>
                </td>
                <td style=\"width:110px;font-size:8pt;color:#888888;font-style: italic;\"><?php echo Yii::t('yii',"Institution")?></td>
                <td style=\"width:110px;font-size:8pt;color:#888888;font-style: italic;\"><?php echo Yii::t('yii',"Collection")?></td>
                <td style=\"width:100px;font-size:8pt;color:#888888;font-style: italic;\"><?php echo Yii::t('yii',"Catalog Number")?></td>
                <td style=\"width:200px;font-size:8pt;color:#888888;font-style: italic;\"><?php echo Yii::t('yii',"Taxonomic Element")?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::encode($recordlevelelementSpecimen1->institutioncode->institutioncode)?></td>
                <td><?php echo CHtml::encode($recordlevelelementSpecimen1->collectioncode->collectioncode)?></td>
                <td><?php echo CHtml::encode($recordlevelelementSpecimen1->occurrenceelement->catalognumber)?></td>
                <td><?php echo WebbeeController::lastTaxa($recordlevelelementSpecimen1)?></td>
            </tr>
        </table>
        <input TYPE='hidden' id='interactionelements_idspecimens1' NAME='interactionelements[idspecimens1]' VALUE=<?php echo $recordlevelelementSpecimen1->idrecordlevelelements; ?> >
    </div>        
    <!-- Intraction -->
    <div class="tablerequired" style="margin-top:15px;margin-bottom:5px;width:98%;padding:8px;letter-spacing:1.5px;font-weight:bold;font-size:12px;text-indent:7px;">
        <?php echo CHtml::encode(Yii::t('yii','Interaction')); ?>
    </div>
    <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable" style="margin-top:0px;margin-bottom:15px;padding:15px;background-color:#f8f8f8;-moz-border-radius-topleft: 0.4em;-moz-border-radius-topright: 0.4em;-moz-border-radius-bottomleft: 0.4em;-moz-border-radius-bottomright: 0.4em;border:1px solid #f3f3f3;">
        <tr>
            <td style="vertical-align:top;width:280px;">
                <?php echo CHtml::label(Yii::t('yii',"Interaction type"),'idinteractiontype'); ?><span class="required">*</span><br/>
                <?php echo CHtml::activeDropDownList($interactionelements, 'idinteractiontype', CHtml::listData(interactiontypes::model()->findAll(), 'idinteractiontype', 'interactiontype'), array('empty'=>'-'));?>
            </td>
            <td style="vertical-align:top;">
                <?php echo CHtml::label(Yii::t('yii',"Related information"),'interactionrelatedinformation'); ?><br/>
                <?php echo CHtml::activeTextArea($interactionelements,'interactionrelatedinformation',array('rows'=>8, 'cols'=>150,'style'=>'width:350px;height:60px;')); ?>
            </td>
        </tr>
    </table>

    <!-- Specimen 2 -->
    <div class="tablerequired" style="width:98%;padding:8px;margin-bottom:5px;letter-spacing:1.5px;font-weight:bold;font-size:12px;text-indent:7px;">
        <?php echo CHtml::encode(Yii::t('yii','Specimen')); ?> 2
    </div>    

    <div id='divSpecimenSelecionada2' class='change'>
        <table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" style=\"background-color:transparent;\">
            <tr>
                <td rowspan=\"2\" style=\"font-weight:bold;width:100px;text-align:left;\">
                    <a href=\"javascript:ativaFiltrosSpecimen(1);\"><?php echo CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Update')))?></a>
                    <a href=\"javascript:ativaFiltrosSpecimen(1);\"><?php echo Yii::t('yii',"Change")?></a>
                </td>
                <td style=\"width:110px;font-size:8pt;color:#888888;font-style: italic;\"><?php echo Yii::t('yii',"Institution")?></td>
                <td style=\"width:110px;font-size:8pt;color:#888888;font-style: italic;\"><?php echo Yii::t('yii',"Collection")?></td>
                <td style=\"width:100px;font-size:8pt;color:#888888;font-style: italic;\"><?php echo Yii::t('yii',"Catalog Number")?></td>
                <td style=\"width:200px;font-size:8pt;color:#888888;font-style: italic;\"><?php echo Yii::t('yii',"Taxonomic Element")?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::encode($recordlevelelementSpecimen1->institutioncode->institutioncode)?></td>
                <td><?php echo CHtml::encode($recordlevelelementSpecimen1->collectioncode->collectioncode)?></td>
                <td><?php echo CHtml::encode($recordlevelelementSpecimen1->occurrenceelement->catalognumber)?></td>
                <td><?php echo WebbeeController::lastTaxa($recordlevelelementSpecimen1)?></td>
            </tr>
        </table>
        <input TYPE='hidden' id='interactionelements_idspecimens2' NAME='interactionelements[idspecimens2]' VALUE=<?php echo $recordlevelelementSpecimen1->idrecordlevelelements; ?> >
    </div>
    <div class="privateRecord" style="margin-top:20px;">
        <?php echo CHtml::activeCheckBox($interactionelements, 'isrestricted')."&nbsp;&nbsp;".Yii::t('yii','Check here to make this record private')."&nbsp;&nbsp;".CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;")); ?>
    </div>
    <div class="saveButton">
        <?php echo CHtml::button($update ? Yii::t('yii', "Save") : Yii::t('yii', "Insert"), array("style"=>"width:140px;font-size:9pt;font-family:verdana;","onclick"=>"submeterFormulario()")); ?>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
<?php
// Caso algum RecordLevelElement tenha sido selecionado anteriormente, exibe as interações relacionadas
if(isset($idrecordlevelelement)) {
    echo Yii::app()->controller->renderPartial('/interactionelements/list', array(
    'interactionelements'=>$interactionelements,
    'interactionelementsList'=>$interactionelementsList,
    'recordlevelelements'=>$recordlevelelements,
    'interactiontypes'=>$interactiontypes,
    'idrecordlevelelement'=>$idrecordlevelelement,
    'pages'=>$pages,
    'exibeControle'=>false,
    'totalRegistros'=>$totalRegistros,
    ));
}
?>
