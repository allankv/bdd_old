
<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/lightbox/recordlevelelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/validationdata.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/jquery.numeric.pack.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/autocomplete.js",CClientScript::POS_END);
$cs->registerScriptFile("js/loadfields.js",CClientScript::POS_END);
$cs->registerScriptFile("js/deleteelements.js",CClientScript::POS_END);
?>


<!-- TEXTO INTRODUTORIO ----------------------------------------------->
<div style="width:80%;margin-top:30px;margin-left:auto;margin-right: auto;">
    <h1 style="margin:0px;"><?php echo Yii::t('yii','Relationship between Specimen and References'); ?> </h1>
    <p class="tooltext"><?php echo Yii::t('yii','This tool allows you to relate reference records to the specified Specimen Record. You may search for any existing reference records to relate to the specimen or create new records that will automatically be linked to it. At the bottom of the page is a list of all (if any) existing relationships between references and this specimen – you may view the reference record, edit it, or delete its relationship to this specimen.'); ?></p>
</div>

<!-- FORMUL�RIO ----------------------------------------------->
<?php echo CHtml::beginForm(); ?>

<!-- N�o deveria aparecer s� se n�o for salvo?-->
<div class="actionbar">
<?php echo CHtml::link(CHtml::image("images/main/ico_seta2.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii', "Go back"),array('recordlevelelements/list','idinstitutioncode'=>$_GET['idinstitutioncode'], 'idcollectioncode'=>$_GET['idcollectioncode'], 'catalognumber'=>$_GET['catalognumber'], 'idscientificname'=>$_GET['idscientificname'], 'scientificnamevalue'=>$_GET['scientificnamevalue']));?>
</div>
<?php echo CHtml::hiddenField('message0',Yii::t('yii','Select the option auto-complete/List for a field already registered or New to define a new value.'));?>
<?php echo CHtml::hiddenField('message1',Yii::t('yii','For new value use NEW'));?>

<br/>

<div class="yiiForm">

    <!-- Icone de Required -->    
    <div style="
         background-color: #ebf4e9;
         padding:10px; padding-left:25px; padding-right:25px; width:75%;
         margin-left:auto; margin-right:auto; margin-top:10px; margin-bottom:30px;
         border: 1px solid #b4f4a6;text-align:center;">

        <h2 style="margin:0px;padding:0px;"><?php echo Yii::t('yii','Selected Specimen'); ?></h2>

        <p style="margin:0px;padding:0px;padding-top:10px;letter-spacing:2px;">
            [<?php echo CHtml::label($recordlevelelements->basisofrecord->basisofrecord, "recordlevelelements");?>]
            [<?php echo CHtml::label($recordlevelelements->institutioncode->institutioncode, "recordlevelelements");?>]
            [<?php echo CHtml::label($recordlevelelements->collectioncode->collectioncode, "recordlevelelements");?>]
            [<b> <?php echo CHtml::label($recordlevelelements->occurrenceelement->catalognumber, "recordlevelelements"); ?></b>]
        </p>

    </div>        
    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired">
        <?php echo CHtml::activeHiddenField($recordlevelelements,'idrecordlevelelements');?>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Create a NEW related reference'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=createrelatedreference',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">                
                <?php echo CHtml::submitButton(Yii::t('yii', "Create"),
                array('submit'=>'index.php?r=referenceselements/create&idinstitutioncode='.$_GET['idinstitutioncode'].
                '&idcollectioncode='.$_GET['idcollectioncode'].
                '&catalognumber='.$_GET['catalognumber'].
                '&idscientificname='.$_GET['idscientificname'],"style"=>"width:140px;height:30px;font-size:9pt;font-family:verdana;"));?>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Select existing related reference'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=selectrelatedreference',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">                
                <?php echo CHtml::submitButton(Yii::t('yii', "Select"),
                array('submit'=>'index.php?r=referenceselements/list&idinstitutioncode='.$_GET['idinstitutioncode'].
                '&idcollectioncode='.$_GET['idcollectioncode'].
                '&catalognumber='.$_GET['catalognumber'].
                '&idscientificname='.$_GET['idscientificname'],"style"=>"width:140px;height:30px;font-size:9pt;font-family:verdana;"));?>
            </td>
        </tr>
    </table>
</div>
<?php echo CHtml::endForm(); ?>
<?php  if($pages !== null) {
    $count_referenceList = $pages->itemCount;
    ?>

<div class="item" style="">

        <?php //if($count_mediaList) {?>

    <div style="text-align:center;margin-top:30px;margin-bottom:25px;"><?php echo CHtml::image("images/main/linha.png", "",array("style"=>"border:0px; padding-left:0px; z-index: 2; width: 820px;")); ?></div>

    <div style="-moz-border-radius-topleft: 0.4em; -moz-border-radius-topright: 0.4em; -moz-border-radius-bottomleft: 0.4em; -moz-border-radius-bottomright: 0.4em;vertical-align:middle;padding:10px;padding-left:20px;width:77%;letter-spacing:2px;margin-left:auto;margin-right:auto;background-color:#eeeeee;margin-bottom:5px;">
                <?php echo Yii::t('yii','References found').": <font style=\"font-size:14px;font-weight:bold;\">".$count_referenceList."</font>"; ?>
    </div>

    <table id="tablelist" class="tablesorter" style="width:auto;display: table;margin-left: auto;margin-right: auto;margin-bottom:0px;">
        <thead>
            <tr style="display:table-row;background-image:url('images/main/table_header.jpg');height:25px;font-family:verdana;font-size:10px;text-align:left;">
                <th style="display: table-cell; width: 20px; border:0px solid gray;vertical-align:middle;padding-left:6px;"></th>
                <th style="display: table-cell; width: 370px;border:0px solid gray;vertical-align:middle;padding-left:3px;"><?php echo CHtml::encode(Yii::t('yii','Title')); ?></th>
                <th style="display: table-cell; width: 160px; border:0px solid gray;vertical-align:middle;padding-left:6px;"><?php echo CHtml::encode(Yii::t('yii','Category')); ?></th>
                <th style="display: table-cell; width: 110px; border:0px solid gray;vertical-align:middle;padding-left:3px;"><?php echo CHtml::encode(Yii::t('yii','Type')); ?></th>
                <th style="text-align:right;display: table-cell; width: 100px; border:0px solid gray;vertical-align:middle;padding-right:25px;">Options</th>
            </tr>
        </thead>
        <tbody>
                    <?php foreach($referencerecordlevelList as $n=>$model):?>
            <tr id="trreference_<?php echo $model->idreferenceselements;?>" style="display:table-row;padding:0px;background-image:url('images/main/table_content.jpg');text-align:center;">
                <td style="display: table-cell;text-align:center;border:0px solid gray;vertical-align:middle;padding:0px;">
                            <?php if($model->isrestricted) echo CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;","title"=>Yii::t('yii','Private')));?>
                </td>
                <td style="display: table-cell;text-align:left;padding-left:10px;border:0px solid gray;vertical-align:middle;">
                            <?php
                            echo CHtml::encode($model->title);
                            ?>
                </td>
                <td style="display: table-cell;text-align:left;padding-left:10px;border:0px solid gray;vertical-align:middle;">
                            <?php
                            echo CHtml::encode($model->categoryreference->categoryreferences);
                            ?>
                </td>
                <td style="display: table-cell; border:0px solid gray;vertical-align:middle;padding-left:3px;">
                            <?php echo CHtml::encode($model->typereference->typereferences); ?>
                </td>
                <td style="display: table-cell; border:0px solid gray;vertical-align:middle;text-align: center;">
                                <?php //echo CHtml::link(CHtml::image("images/main/ico_buscar.gif", "",array("style"=>"border:0px;")),array('referenceselements/show','id'=>$model->idreferenceselements))." | "; ?>
                                <?php echo CHtml::link(CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Update'))),array('referenceselements/update','id'=>$model->idreferenceselements))." | "; ?>
                                <?php echo $model->URI==''?'':CHtml::link(CHtml::image("images/main/weblink.png", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Link to reference'))),$model->URI,array('target'=>'_blank'))." | "; ?>
                                <?php $msg = Yii::t('yii','Are you sure to delete the');
                                $title = (string)$model->title;
                                echo CHtml::link(CHtml::image("images/main/canc.gif", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Delete'))), "", array('onclick'=>"deleteReferenceRecordlevel('$msg',$model->idreferenceselements,$recordlevelelements->idrecordlevelelements,'$title');")); ?>
                </td>
            </tr>
                    <?php endforeach; ?>
        </tbody>
    </table>
    <div style="width:75%;margin-top:10px;margin-bottom:10px;margin-left: auto;margin-right:auto;text-align:right;"><?php $this->widget('CLinkPager',array('pages'=>$pages)); ?></div>
    <div style="-moz-border-radius-topleft: 0.4em; -moz-border-radius-topright: 0.4em; -moz-border-radius-bottomleft: 0.4em; -moz-border-radius-bottomright: 0.4em;vertical-align:middle;padding:5px;padding-left:25px;width:77%;margin-left:auto;margin-right:auto;background-color:#eeeeee;margin-bottom:5px;margin-top:20px;">
                <?php echo CHtml::image("images/main/ico_buscar.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Show')."&nbsp; | &nbsp;&nbsp;"; ?>
                <?php echo CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Update')."&nbsp; | &nbsp;&nbsp;"; ?>
                <?php echo CHtml::image("images/main/canc.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Delete')."&nbsp; | &nbsp;&nbsp;"; ?>
                <?php echo CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Is Private')."&nbsp; | &nbsp;&nbsp;"; ?>
   </div>
            <?php } ?>
    <br/>
</div>

    <?php //}?>
<br/><br/>


