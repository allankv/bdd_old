<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/lightbox/collectingeventelements.js",CClientScript::POS_HEAD);
$cs->registerCssFile("css/lightbox.css");
?>

<div class="yiiForm">
    <p>
        <?php
        if($showActionButton)
            echo Yii::t('yii',"Fields with * are required.");
        ?>
    </p>


    <?php
    if($showActionButton)
        echo CHtml::beginForm(); ?>


    <?php
    if($showActionButton)
        echo CHtml::errorSummary($collectingeventelements); ?>


    <div class="tablerow" id='divsamplingprotocol'>
        <div class="tablelabelcel">
            <div class="label">
                <?php echo CHtml::label(Yii::t('yii','Sampling protocol'), "collectingeventelements");?>
            </div>
        </div>
        <div class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=samplingprotocol',array('rel'=>'lightbox'));?>
        </div>
        <div class="tablefieldcel">
            <div class="field">
                <?php echo CHtml::activeHiddenField($collectingeventelements,"idsamplingprotocol");?>
                <?php echo CHtml::hiddenField("samplingprotocolvalue");?>


                <?php
                $this->widget('CAutoComplete',
                        array(
                        'value'=>$samplingprotocols->samplingprotocol,
                        //name of the html field that will be generated
                        'name'=>'q',
                        //replace controller/action with real ids
                        'url'=>'index.php?r=autocompleterecordlevelelements',
                        'max'=>15, //specifies the max number of items to display

                        //specifies the number of chars that must be entered
                        //before autocomplete initiates a lookup
                        'minChars'=>2,
                        'delay'=>500, //number of milliseconds before lookup occurs
                        'matchCase'=>false, //match case when performing a lookup?
                        'id'=>'samplingprotocol',
                        'extraParams'=>array('tableField'=>'samplingprotocol', 'table'=>'samplingprotocols'),
                        //any additional html attributes that go inside of
                        //the input field can be defined here
                        'htmlOptions'=>array('class'=>'textboxtext'),
                        'methodChain'=>".result(function(event,item){
                                        \$(\"#collectingeventelements_idsamplingprotocol\").val(item[1]);
                                        \$(\"samplingprotocolvalue\").val(item[0]);

                                        escondeBotaoResetCollectingEventElements();
                                                        var camposReset = new Array();
                                                        camposReset.push(0);

//                                                \$(\"#divsamplingprotocolReset\").css(\"display\",\"block\");
//
//                                                if (item[0]!=''){
//                                                        dasabilitaCampos(\"samplingprotocol\");
//                                                        $('#divsamplingprotocolValor').text(item[0]);
//                                                }else
//                                                        habilitaCampos(\"samplingprotocol\");

                                                camposReset.push(\"samplingprotocol\");
                                                camposPreenchidosCollectingEventElements.push(camposReset);

                             })",
                ));
                ?>
                &nbsp;&nbsp;<a href="index.php?r=samplingprotocols/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
                &nbsp;&nbsp;<a href="index.php?r=samplingprotocols/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
            </div>
        </div>
        <div class="simple" id='divsamplingprotocolLabel' style='display: none;'>

            <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
                <tr>
                    <td style="width: 50px;" >
                        <?php //echo CHtml::activeLabelEx($collectingeventelements,'idcollectingmethod');
                        echo CHtml::label(Yii::t('yii','Sampling protocol'), "collectingeventelements");
                        ?>
                    </td>
                    <td style="width: 272px;">
                        <span class="simple" id='divsamplingprotocolValor' ></span>
                    </td>
                    <td>
                        <span class="simple" id='divsamplingprotocolReset' style='display:none;' >
                            &nbsp;&nbsp;<a href="#" onclick=limpaCamposCollectingEventElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <div class="tablerow" id='divestablishmentmeans'>
        <div class="tablelabelcel">
            <div class="label">
                <?php echo CHtml::label(Yii::t('yii','Establishment means'), "collectingeventelements"); ?>
            </div>
        </div>
        <div class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=establishmentmeans',array('rel'=>'lightbox'));?>
        </div>
        <div class="tablefieldcel">
            <div class="field">
                <?php echo CHtml::activeDropDownList($collectingeventelements, "idestablishmentmeans", CHtml::listData(establishmentmeans::model()->findAll(), 'idestablishmentmeans', 'establishmentmeans'), array('empty'=>'-'));?>
            </div>
        </div>
    </div>

    <div class="tablerow">
        <div class="tablelabelcel">
            <div class="label">
                <?php echo CHtml::label(Yii::t('yii','Earliest date collected'), "collectingeventelements");?>
            </div>
        </div>
        <div class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=earliestdatecollected',array('rel'=>'lightbox'));?>
        </div>
        <div class="tablefieldcel">
            <div class="field">
                <?php
                //Chama o objeto do jquery pelo framework
                $this->widget('application.extensions.jui.EDatePicker',
                        array(
                        'name'=>'collectingeventelements[earliestdatecollected]',
                        'language'=>'en',
                        'mode'=>'imagebutton',
                        'theme'=>'dotluv',
                        'value'=> ($update ? $collectingeventelements->earliestdatecollected : ""),
                        'dateformat'=>'mm/dd/yy',
                        'htmlOptions'=>array('size'=>13)
                        )
                );
                ?>
                <span style="font-size: 10px;">mm/dd/yyyy</span>
            </div>
        </div>
    </div>

    <div class="tablerow">
        <div class="tablelabelcel">
            <div class="label">
                <?php echo CHtml::label(Yii::t('yii','Lastest date collected'), "collectingeventelements");?>
            </div>
        </div>
        <div class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=lastestdatecollected',array('rel'=>'lightbox'));?>
        </div>
        <div class="tablefieldcel">
            <div class="field">
                <?php
                $this->widget('application.extensions.jui.EDatePicker',
                        array(
                        'name'=>'collectingeventelements[lastestdatecollected]',
                        'language'=>'en',
                        'mode'=>'imagebutton',
                        'theme'=>'dotluv',
                        'value'=>($update ? $collectingeventelements->lastestdatecollected : ""),
                        'dateformat'=>'mm/dd/yy',
                        'htmlOptions'=>array('size'=>13)
                        )
                );
                ?>
                <span style="font-size: 10px;">mm/dd/yyyy</span>
            </div>
        </div>
    </div>

    <div class="tablerow">
        <div class="tablelabelcel">
            <div class="label">
                <?php echo CHtml::label(Yii::t('yii','Day of year'), "collectingeventelements");?>
            </div>
        </div>
        <div class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=startdayofyear',array('rel'=>'lightbox'));?>
        </div>
        <div class="tablefieldcel">
            <div class="field">
                <?php
                $date = getdate();
                //calculation of leap year
                if ((substr(strrev(($date['year']/4)),0,2) <> "00") && ($date['year']%4 == 0)) {
                    $days = 366;
                } else if((substr(strrev(($date['year']/4)),0,2) == "00") && ($date['year']%400 == 0)) {
                    $days = 366;
                } else {
                    $days = 365;
                }
                for($i=1;$i<=$days;$i++) {
                    $dayofyear[$i]=$i;
                }
                echo CHtml::dropDownList("collectingeventelements[startdayofyear]", ($update ? $collectingeventelements->startdayofyear : ""), $dayofyear, array('empty'=>'-', 'id'=>'collectingeventelements_startdayofyear'));?>
            </div>
        </div>
    </div>

    <div class="tablerow" id='divcollectedby'>
        <div class="tablelabelcel">
            <div class="label">
                <?php echo CHtml::label(Yii::t('yii','Collected By'), "collectingeventelements");?>
            </div>
        </div>
        <div class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collectedby',array('rel'=>'lightbox'));?>
        </div>
        <div class="tablefieldcel">
            <div class="field">
                <?php echo CHtml::activeHiddenField($collectingeventelements,"idcollectedby")?>
                <?php echo CHtml::hiddenField("collectedbyvalue");?>
                <?php $this->widget('CAutoComplete',
                        array(
                        'value'=>$collectedbys->collectedby,
                        //name of the html field that will be generated
                        'name'=>'q',
                        //replace controller/action with real ids
                        'url'=>'index.php?r=autocompleterecordlevelelements',
                        'max'=>15, //specifies the max number of items to display
                        //specifies the number of chars that must be entered
                        //before autocomplete initiates a lookup
                        'minChars'=>2,
                        'delay'=>500, //number of milliseconds before lookup occurs
                        'matchCase'=>false, //match case when performing a lookup?
                        'id'=>'collectedby',
                        'extraParams'=>array('tableField'=>'collectedby', 'table'=>'collectedby'),
                        //any additional html attributes that go inside of
                        //the input field can be defined here
                        'htmlOptions'=>array('class'=>'textboxtext'),
                        'methodChain'=>".result(function(event,item){
                                        \$(\"#collectingeventelements_idcollectedby\").val(item[1]);
                                        \$(\"#collectedbyvalue\").val(item[0]);

                                        escondeBotaoResetCollectingEventElements();
                                                        var camposReset = new Array();
                                                        camposReset.push(0);

//                                                \$(\"#divcollectedbyReset\").css(\"display\",\"block\");
//
//                                                if (item[0]!=''){
//                                                        dasabilitaCampos(\"collectedby\");
//                                                        $('#divcollectedbyValor').text(item[0]);
//                                                }else
//                                                        habilitaCampos(\"collectedby\");

                                                camposReset.push(\"collectedby\");
                                                camposPreenchidosCollectingEventElements.push(camposReset);


                             })",
                ));
                ?>
                &nbsp;&nbsp;<a href="index.php?r=collectedby/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
                &nbsp;&nbsp;<a href="index.php?r=collectedby/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
            </div>
        </div>
    </div>


    <div class="simple" id='divcollectedbyLabel' style='display: none;'>

        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
                    <?php echo CHtml::label(Yii::t('yii','Collected By'), "collectingeventelements");?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divcollectedbyValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divrecordedbyReset' style='display:none;' >
                        &nbsp;&nbsp;<a href="#" onclick=limpaCamposCollectingEventElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>

    </div>

    <?php
    if($showActionButton) {
        echo "<div class=\"action\">";
        echo CHtml::submitButton($update ? Yii::t('yii', "Save") : Yii::t('yii', "Create"));
        echo "</div>";
    }
    ?>


    <?php
    if($showActionButton)
        echo CHtml::endForm(); ?>
</div><!-- yiiForm -->