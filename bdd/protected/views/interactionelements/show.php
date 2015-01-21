<?php
//$cs=Yii::app()->clientScript;
//$cs->registerScriptFile("js/alertbox/jqModal.js",CClientScript::POS_HEAD);
//$cs->registerScriptFile("js/alertbox/jqModal.css",CClientScript::POS_HEAD);
//$cs->registerScriptFile("js/alertbox/jqConfirm.js",CClientScript::POS_HEAD);
?>


    <?php
    
    if(isset($idrecordlevelelement)) {
    	echo "<div class='actionbar'>";
        echo CHtml::link(CHtml::image("images/main/ico_seta2.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii', "Go back"),array('recordlevelelements/list','idinstitutioncode'=>$_GET['idinstitutioncode'], 'idcollectioncode'=>$_GET['idcollectioncode'], 'catalognumber'=>$_GET['catalognumber'], 'idscientificname'=>$_GET['idscientificname'], 'scientificnamevalue'=>$_GET['scientificnamevalue']));
        echo "</div>";
    }    
    
//    if(isset($idrecordlevelelement)) {
//        echo CHtml::link(Yii::t('yii', "Create new Interaction Record"), array('/interactionelements/specimenInteraction','idrecordlevelelement'=>$idrecordlevelelement));
//    }else {
//        if(!$inserindoNovamente) {
//            echo CHtml::link(Yii::t('yii', "Create new Interaction Record"), array('create'));
//        }
//    }
    ?>
    <?php //echo CHtml::linkButton(Yii::t('yii', "Delete this record"),array('submit'=>array('delete','class'=>'confirm','id'=>$interactionelements->idinteractionelements),'confirm'=>Yii::t('yii', 'Are you sure to delete?'))); ?>

<div class="success" style="width:50%;">
    <table style="background-color:transparent;width:100%;" align="center">
        <tr>
            <td colspan="3">
                <div  style="background-color:#d4e5cc;text-align:left;text-indent:40px;padding:5px;margin-bottom:10px;font-size:13px;font-weight:bold;letter-spacing:1px;">
                    <?php echo CHtml::image("images/main/success.png", "",array("style"=>"border:0px;"));?>&nbsp;&nbsp;
                    <?php echo CHtml::encode(Yii::t('yii','Interaction data was recorded successfully'));?>
                </div>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcelsuccess"><?php echo CHtml::encode(Yii::t('yii','Specimen 1')); ?></td>
            <td style="width:10px;">&nbsp;</td>
            <td class="tablefieldcelsuccess" style="background-color:#f2f9ee;"><?php echo CHtml::encode($recordlevelelements->findByPk($interactionelements->idspecimens1)->globaluniqueidentifier);?></td>
        </tr>
        <tr>
            <td class="tablelabelcelsuccess"><?php echo CHtml::encode(Yii::t('yii','Interaction type')); ?></td>
            <td></td>
            <td class="tablefieldcelsuccess"><?php echo CHtml::encode($interactiontypes->findByPk($interactionelements->idinteractiontype)->interactiontype); ?></td>
        </tr>
        <tr>
            <td class="tablelabelcelsuccess"><?php echo CHtml::encode(Yii::t('yii','Specimen 2')); ?></td>
            <td></td>
            <td class="tablefieldcelsuccess" style="background-color:#f2f9ee;"><?php echo CHtml::encode($recordlevelelements->findByPk($interactionelements->idspecimens2)->globaluniqueidentifier); ?></td>
        </tr>
        <tr>
            <td class="tablelabelcelsuccess"><?php echo CHtml::encode(Yii::t('yii','Date last modified')); ?></td>
            <td></td>
            <td class="tablefieldcelsuccess"><?php echo CHtml::encode($interactionelements->modified); ?></td>
        </tr>
        <tr>
            <td class="tablelabelcelsuccess"><?php echo CHtml::encode(Yii::t('yii','Related information')); ?></td>
            <td></td>
            <td class="tablefieldcelsuccess" style="font-style:italic;background-color:#f2f9ee;padding-top:5px;padding-bottom:5px;"><?php echo CHtml::encode($interactionelements->interactionrelatedinformation); ?></td>
        </tr>
        <tr>
            <td class="tablelabelcelsuccess"><?php echo CHtml::encode(Yii::t('yii','Is Private')); ?></td>
            <td></td>
            <td class="tablefieldcelsuccess">
            <?php
            if (CHtml::encode($interactionelements->isrestricted)){
                    echo CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;";
                    echo CHtml::encode(Yii::t('yii','Yes'));
            }else {
                echo CHtml::encode(Yii::t('yii','No'));}?>
            </td>
        </tr>
    </table>
</div>

<?php
/*
	 * Caso algum RecordLevelElement tenha sido selecionado anteriormente, exibe as interações relacionadas
*/
if(isset($idrecordlevelelement)) {

    echo Yii::app()->controller->renderPartial('/interactionelements/list', array(
    'interactionelements'=>$interactionelements,
    'interactionelementsList'=>$interactionelementsList,
    'recordlevelelements'=>$recordlevelelements,
    'interactiontypes'=>$interactiontypes,
    'idrecordlevelelement'=>$idrecordlevelelement,
    'exibeControle'=>false,
    'pages'=>$pages,
    'totalRegistros'=>$totalRegistros,
    ));


}

?>
                            <?php
//                            if($interactionelements->getAttribute("idinteractionelements")==$model->idinteractionelements) {
//                                echo "background-color: #ADCEFF;";
//                            }else {
//                                echo "";
//                            }
                                ?>

<!--                <td
                            <?php
                            if($interactionelements->getAttribute("idinteractionelements")==$model->idinteractionelements) {
                                echo "style='background-color: #ADCEFF';";
                            }else {
                                echo "";
                            }
                            ?>
                    >

                    <a href="javascript:controleExibicao('obj<?php echo $idinteractionelement; ?>')" >more</a>
                </td>-->

<!--
            <tr  style="display:table-row;background-image:url('images/main/table_header.jpg');" >
                <td colspan="5" style="padding: 0px 0px 0px 0px;display: table-cell;"  >
                    <div id='obj<?php echo $idinteractionelement; ?>'  STYLE='display:none;'  >
                        <table width="100%" >
                            <tr>
                                <td><strong>Specimen 1</strong></td>
                            </tr>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco recordlevelelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens1)->globaluniqueidentifier<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->idtypes<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->idinstitutioncode<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->idownerinstitution<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->idcollectioncode<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->iddataset<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->rights<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->rightsholder<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->accessrights<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->bibliographiccitation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->informationwithheld<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->datageneralizations<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->dynamicproperties<>"")
//
//
//                                        ) {


                                            ?>

                            <tr>
                                <td>

                                    <a href="javascript:controleExibicao('objRegister<?php echo $idinteractionelement."1"; ?>')" >Record level elements</a>
                                    <div  id='objRegister<?php //echo $idinteractionelement."1"; ?>' STYLE='display:none;'  >

                                        <table width="100%" >


                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->globaluniqueidentifier<>"") { ?>

                                            <tr>
                                                <td  width="30%" >Global unique identifier</td>
                                                <td  ><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->globaluniqueidentifier); ?></td>
                                            </tr>

                                                                <?php //} ?>


                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->idtypes<>"") { ?>

                                            <tr>
                                                <td width="30%" >Type</td>
                                                <td ><?php //echo CHtml::encode(types::model()->findByPk($recordlevelelements->findByPk($model->idspecimens1)->idtypes)->types); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->idinstitutioncode<>"") { ?>

                                            <tr>
                                                <td width="30%" >Institution code</td>
                                                <td><?php //echo CHtml::encode(institutioncodes::model()->findByPk($recordlevelelements->findByPk($model->idspecimens1)->idinstitutioncode)->institutioncode); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->idownerinstitution<>"") { ?>

                                            <tr>
                                                <td width="30%" >Owner Institution code</td>
                                                <td><?php //echo CHtml::encode(ownerinstitution::model()->findByPk($recordlevelelements->findByPk($model->idspecimens1)->idownerinstitution)->ownerinstitution); ?></td>
                                            </tr>

                                                                <?php //} ?>


                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->idcollectioncode<>"") { ?>

                                            <tr>
                                                <td width="30%" >Collection code</td>
                                                <td><?php //echo CHtml::encode(collectioncodes::model()->findByPk($recordlevelelements->findByPk($model->idspecimens1)->idcollectioncode)->collectioncode); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->dataset->dataset<>"") { ?>

                                            <tr>
                                                <td width="30%" >Data set</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->dataset->dataset); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->rights<>"") { ?>

                                            <tr>
                                                <td width="30%" >Rights</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->rights); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->rightsholder<>"") { ?>

                                            <tr>
                                                <td width="30%" >Rights holder</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->rightsholder); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->accessrights<>"") { ?>

                                            <tr>
                                                <td width="30%" >Access rights</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->accessrights); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->bibliographiccitation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Bibliographic citation</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->bibliographiccitation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->informationwithheld<>"") { ?>

                                            <tr>
                                                <td width="30%" >Information with held</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->informationwithheld); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->datageneralizations<>"") { ?>

                                            <tr>
                                                <td width="30%" >Data generalizations</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->datageneralizations); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->dynamicproperties<>"") { ?>

                                            <tr>
                                                <td width="30%" >Dynamic properties</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->dynamicproperties); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>

                                    </div>
                                </td>
                            </tr>
                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco occurrenceelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->recordnumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->catalognumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->othercatalognumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->occurrencedetails<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->preparation->preparation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->recordedby->recordedby<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->individual->individual<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->preparation->preparation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->associatedsequence->associatedsequence<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->occurrenceremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->individualcount<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->occurrencestatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->sex->sex<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->disposition->disposition<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->behavior->behavior<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->establishmentmean->establishmentmeans<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->reproductivecondition->reproductivecondition<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->lifestage->lifestage<>"")
//
//
//                                        ) {


                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objOcurrence<?php echo $idinteractionelement."1"; ?>')" >Occurrence Elements</a>

                                    <div  id='objOcurrence<?php echo $idinteractionelement."1"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->recordnumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Record number</td>
                                                <td ><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->recordnumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->catalognumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Catalog number</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->catalognumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->othercatalognumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Other catalog number</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->othercatalognumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->occurrencedetails<>"") { ?>

                                            <tr>
                                                <td width="30%" >Occurrence details</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->occurrencedetails); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->preparation->preparation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Preparation</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->preparation->preparation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->recordedby->recordedby<>"") { ?>

                                            <tr>
                                                <td width="30%" >Recorded by</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->recordedby->recordedby); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->individual->individual<>"") { ?>

                                            <tr>
                                                <td width="30%" >Individual</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->individual->individual); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->associatedsequence->associatedsequence<>"") { ?>

                                            <tr>
                                                <td width="30%" >Associated sequences</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->associatedsequence->associatedsequence); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->occurrenceremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Occurrence remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->occurrenceremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->individualcount<>"") { ?>

                                            <tr>
                                                <td width="30%" >Individual count</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->individualcount); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->occurrencestatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Occurrence status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->occurrencestatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->sex->sex<>"") { ?>

                                            <tr>
                                                <td width="30%" >Sex</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->sex->sex); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->disposition->disposition<>"") { ?>

                                            <tr>
                                                <td width="30%" >Disposition</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->disposition->disposition); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->establishmentmean->establishmentmeans<>"") { ?>

                                            <tr>
                                                <td width="30%" >Establishment means</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->establishmentmean->establishmentmeans); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->behavior->behavior<>"") { ?>

                                            <tr>
                                                <td width="30%" >Behavior</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->behavior->behavior); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->reproductivecondition->reproductivecondition<>"") { ?>

                                            <tr>
                                                <td width="30%" >Reproductive condition</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->reproductivecondition->reproductivecondition); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->reproductivecondition->reproductivecondition<>"") { ?>

                                            <tr>
                                                <td width="30%" >Life stage</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->occurrenceelement->lifestage->lifestage); ?></td>
                                            </tr>

                                                                <?php //} ?>


                                        </table>


                                    </div>
                                </td>
                            </tr>

                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco curatorialelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->typestatus->typestatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->identifiedby->identifiedby<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->associatedsequence->associatedsequence<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->preparation->preparation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->identifiedby->identifiedby<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->fieldnumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->individualcount<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->fieldnotes<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimeventdate<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimelevation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimdepth<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->dateidentified<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimdepth<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->disposition->disposition<>"")
//
//                                        ) {

                                            ?>
                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objCuratorial<?php echo $idinteractionelement."1"; ?>')" >Curatorial Elements</a>


                                    <div  id='objCuratorial<?php echo $idinteractionelement."1"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->typestatus->typestatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Type status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->typestatus->typestatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->identifiedby->identifiedby<>"") { ?>

                                            <tr>
                                                <td width="30%" >identified by</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->identifiedby->identifiedby); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->associatedsequence->associatedsequence<>"") { ?>

                                            <tr>
                                                <td width="30%" >Associated sequences</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->associatedsequence->associatedsequence); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->preparation->preparation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Preparations</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->preparation->preparation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->fieldnumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Field number</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->fieldnumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->individualcount<>"") { ?>

                                            <tr>
                                                <td width="30%" >Individual count</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->individualcount); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->fieldnotes<>"") { ?>

                                            <tr>
                                                <td width="30%" >Field notes</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->fieldnotes); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimeventdate<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim event date</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimeventdate); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimelevation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim elevation</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimelevation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimdepth<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim depth</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->verbatimdepth); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->dateidentified<>"") { ?>

                                            <tr>
                                                <td width="30%" >Date identified</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->dateidentified); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->disposition->disposition<>"") { ?>

                                            <tr>
                                                <td width="30%" >Disposition</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->curatorialelement->disposition->disposition); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>


                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco identificationelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->identificationqualifier->identificationqualifier<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->identifiedby->identifiedby<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->typestatus->typestatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->identificationremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->dateidentified<>"")
//
//                                        ) {

                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objidentification<?php echo $idinteractionelement."1"; ?>')" >identification elements</a>

                                    <div  id='objidentification<?php echo $idinteractionelement."1"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->identificationqualifier->identificationqualifier<>"") { ?>

                                            <tr>
                                                <td width="30%" >identification qualif.</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->identificationqualifier->identificationqualifier); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->identifiedby->identifiedby<>"") { ?>

                                            <tr>
                                                <td width="30%" >identified by</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->identifiedby->identifiedby); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->typestatus->typestatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Type status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->typestatus->typestatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->identificationremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >identification remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->identificationremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->dateidentified<>"") { ?>

                                            <tr>
                                                <td width="30%" >Data identified</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->identificationelement->dateidentified); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>


                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco eventelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens1)->eventelement->samplingprotocol->samplingprotocol<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->eventelement->samplingeffort<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->eventelement->habitat->habitat<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->eventelement->verbatimeventdate<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->eventelement->eventdate<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->eventelement->eventtime<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->eventelement->fieldnumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->eventelement->fieldnotes<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->eventelement->eventremarks<>"")
//
//                                        ) {

                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objEvent<?php echo $idinteractionelement."1"; ?>')" >Event elements</a>

                                    <div  id='objEvent<?php echo $idinteractionelement."1"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->eventelement->samplingprotocol->samplingprotocol<>"") { ?>

                                            <tr>
                                                <td width="30%" >Sampling protocol</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->eventelement->samplingprotocol->samplingprotocol); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->eventelement->samplingeffort<>"") { ?>

                                            <tr>
                                                <td width="30%" >Sampling effort</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->eventelement->samplingeffort); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->eventelement->habitat->habitat<>"") { ?>

                                            <tr>
                                                <td width="30%" >Habitat</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->eventelement->habitat->habitat); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->eventelement->verbatimeventdate<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim event date</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->eventelement->verbatimeventdate); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->eventelement->eventdate<>"") { ?>

                                            <tr>
                                                <td width="30%" >Event date</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->eventelement->eventdate); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->eventelement->eventtime<>"") { ?>

                                            <tr>
                                                <td width="30%" >Event time</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->eventelement->eventtime); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->eventelement->fieldnumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Field number</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->eventelement->fieldnumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->eventelement->fieldnotes<>"") { ?>

                                            <tr>
                                                <td width="30%" >Field notes</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->eventelement->fieldnotes); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->eventelement->eventremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Event remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->eventelement->eventremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>

                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco taxonomicelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->kingdom->kingdom<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->phylum->phylum<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->class->class<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->order->order<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->family->family<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->genus->genus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->subgenus->subgenus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->specificepithet->specificepithet<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonrank->taxonrank<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->scientificnameauthorship->scientificnameauthorship<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nomenclaturalcode->nomenclaturalcode<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->acceptednameusage->acceptednameusage<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->parentnameusage->parentnameusage<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->originalnameusage->originalnameusage<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nameaccordingto->nameaccordingto<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->originalnameusage->originalnameusage<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nameaccordingto->nameaccordingto<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->namepublishedin->namepublishedin<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonconcept->taxonconcept<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nomenclaturalstatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->vernacularname<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->verbatimtaxonrank<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonomicstatus->taxonomicstatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->verbatimtaxonrank<>"")
//
//
//                                        ) {

                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objTaxonomy<?php echo $idinteractionelement."1"; ?>')" >Taxonomic elements</a>

                                    <div  id='objTaxonomy<?php //echo $idinteractionelement."1"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->kingdom->kingdom<>"") { ?>

                                            <tr>
                                                <td width="30%" >Kingdom</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->kingdom->kingdom); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->phylum->phylum<>"") { ?>

                                            <tr>
                                                <td width="30%" >Phylum</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->phylum->phylum); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->class->class<>"") { ?>

                                            <tr>
                                                <td width="30%" >Class</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->class->class); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->order->order<>"") { ?>

                                            <tr>
                                                <td width="30%" >Order</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->order->order); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->family->family<>"") { ?>

                                            <tr>
                                                <td width="30%" >Family</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->family->family); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->genus->genus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Genus</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->genus->genus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->subgenus->subgenus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Sub genus</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->subgenus->subgenus); ?></td>
                                            </tr>

                                                                <?php //} ?>


                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->specificepithet->specificepithet<>"") { ?>

                                            <tr>
                                                <td width="30%" >Specific epithet</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->specificepithet->specificepithet); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->infraspecificepithet->infraspecificepithet<>"") { ?>

                                            <tr>
                                                <td width="30%" >Infra specific epithet</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->infraspecificepithet->infraspecificepithet); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonrank->taxonrank<>"") { ?>

                                            <tr>
                                                <td width="30%" >Taxon rank</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonrank->taxonrank); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->scientificnameauthorship->scientificnameauthorship<>"") { ?>

                                            <tr>
                                                <td width="30%" >Scientific name authorship</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->scientificnameauthorship->scientificnameauthorship); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nomenclaturalcode->nomenclaturalcode<>"") { ?>

                                            <tr>
                                                <td width="30%" >Nomenclatural code</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nomenclaturalcode->nomenclaturalcode); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->acceptednameusage->acceptednameusage<>"") { ?>

                                            <tr>
                                                <td width="30%" >Accepted name usage</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->acceptednameusage->acceptednameusage); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->parentnameusage->parentnameusage<>"") { ?>

                                            <tr>
                                                <td width="30%" >Parent name usage</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->parentnameusage->parentnameusage); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->originalnameusage->originalnameusage<>"") { ?>

                                            <tr>
                                                <td width="30%" >Original name usage</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->originalnameusage>originalnameusage); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nameaccordingto->nameaccordingto<>"") { ?>

                                            <tr>
                                                <td width="30%" >Name according to</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nameaccordingto->nameaccordingto); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->namepublishedin->namepublishedin<>"") { ?>

                                            <tr>
                                                <td width="30%" >Name published in</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->namepublishedin->namepublishedin); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonconcept->taxonconcept<>"") { ?>

                                            <tr>
                                                <td width="30%" >Taxon concept</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonconcept->taxonconcept); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nomenclaturalstatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Nomenclatural status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->nomenclaturalstatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->vernacularname<>"") { ?>

                                            <tr>
                                                <td width="30%" >Vernacular name</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->vernacularname); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->verbatimtaxonrank<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbation taxon rank</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->verbatimtaxonrank); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonomicstatus->taxonomicstatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Taxonomic status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonomicstatus->taxonomicstatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Taxon remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->taxonomicelement->taxonremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>


                                    </div>
                                </td>
                            </tr>

                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco locality elements

//                                        if(($recordlevelelements->findByPk($model->idspecimens1)->localityelement->continent->continent<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->waterbody->waterbody<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->islandgroup->islandgroup<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->island->island<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->country->country<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->municipality->municipality<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->locality->locality<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->georeferenceverificationstatus->georeferenceverificationstatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->habitat->habitat<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->minimumelevationinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->maximumelevationinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->minimumdepthinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->maximumdepthinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->minimumdistanceabovesurficeinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->maximumdistanceabovesurficeinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->locationaccordingto<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->locationremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimdepth<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimelevation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimlocality<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->coordinateprecision<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->footprintsrs<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimsrs<>"")
//
//                                        ) {

                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objLocality<?php echo $idinteractionelement."1"; ?>')" >Locality elements</a>

                                    <div  id='objLocality<?php echo $idinteractionelement."1"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->continent->continent<>"") { ?>

                                            <tr>
                                                <td width="30%" >Continent</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->continent->continent); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->waterbody->waterbody<>"") { ?>

                                            <tr>
                                                <td width="30%" >Water body</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->waterbody->waterbody); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->islandgroup->islandgroup<>"") { ?>

                                            <tr>
                                                <td width="30%" >Island group</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->islandgroup->islandgroup); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->island->island<>"") { ?>

                                            <tr>
                                                <td width="30%" >Island</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->island->island); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->country->country<>"") { ?>

                                            <tr>
                                                <td width="30%" >Country</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->country->country); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->municipality->municipality<>"") { ?>

                                            <tr>
                                                <td width="30%" >Municipality</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->municipality->municipality); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->locality->locality<>"") { ?>

                                            <tr>
                                                <td width="30%" >Locality</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->locality->locality); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->georeferenceverificationstatus->georeferenceverificationstatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verification status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->georeferenceverificationstatus->georeferenceverificationstatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->habitat->habitat<>"") { ?>

                                            <tr>
                                                <td width="30%" >Habitat</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->habitat->habitat); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->minimumelevationinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Minimum elevation in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->minimumelevationinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->maximumelevationinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Maximum elevation in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->maximumelevationinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->minimumdepthinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Minimum depth in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->minimumdepthinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->maximumdepthinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Maximum depth in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->maximumdepthinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->minimumdistanceabovesurficeinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Minimum distance above surfice in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->minimumdistanceabovesurficeinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->maximumdistanceabovesurficeinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Maximum distance above surfice in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->maximumdistanceabovesurficeinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->locationaccordingto<>"") { ?>

                                            <tr>
                                                <td width="30%" >Location according to</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->locationaccordingto); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->locationremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Location remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->locationremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimdepth<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim depth</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimdepth); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimelevation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim elevation</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimelevation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimlocality<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim locality</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimlocality); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->coordinateprecision<>"") { ?>

                                            <tr>
                                                <td width="30%" >Cordinate precision</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->coordinateprecision); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->footprintsrs<>"") { ?>

                                            <tr>
                                                <td width="30%" >Footprint SRS</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->footprintsrs); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimsrs<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim SRS</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->localityelement->verbatimsrs); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>

                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco geospatialelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->decimallongitude<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->decimallatitude<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->coordinateuncertaintyinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->geodeticdatum<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->pointradiusspatialfit<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimcoordinates<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimlatitude<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimlongitude<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimcoordinatesystem<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->georeferenceprotocol<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->georeferencesource<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->georeferenceremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->footprintwkt<>"")
//
//                                        ) {

                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objGeospatial<?php echo $idinteractionelement."1"; ?>')" >Geospatial elements</a>

                                    <div  id='objGeospatial<?php echo $idinteractionelement."1"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->decimallongitude<>"") { ?>

                                            <tr>
                                                <td width="30%" >Decimal longitude</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->decimallongitude); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->decimallatitude<>"") { ?>

                                            <tr>
                                                <td width="30%" >Decimal latitude</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->decimallatitude); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->coordinateuncertaintyinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%"  width="30%" >Coordinate uncertainty</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->coordinateuncertaintyinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->geodeticdatum<>"") { ?>

                                            <tr>
                                                <td width="30%" >Geodetic datum</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->geodeticdatum); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->pointradiusspatialfit<>"") { ?>

                                            <tr>
                                                <td width="30%" >Point radious spatial fit</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->pointradiusspatialfit); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimcoordinates<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim coordinates</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimcoordinates); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimlatitude<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim latitude</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimlatitude); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimlongitude<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim longitude</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimlongitude); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimcoordinatesystem<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim coordinate system</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->verbatimcoordinatesystem); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->georeferenceprotocol<>"") { ?>

                                            <tr>
                                                <td width="30%" >Georeference protocol</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->georeferenceprotocol); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->georeferencesource->georeferencesource<>"") { ?>

                                            <tr>
                                                <td width="30%" >Georeference sources</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->georeferencesource->georeferencesource); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->georeferenceremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Georeference remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->georeferenceremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->footprintwkt<>"") { ?>

                                            <tr>
                                                <td width="30%" >Footprint WKT</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->footprintwkt); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->footprintspatialfit<>"") { ?>

                                            <tr>
                                                <td width="30%" >Footprint spatial fit</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens1)->geospatialelement->footprintspatialfit); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>

                                            <?php //} ?>

                            <tr>
                                <td><strong>Specimen 2</strong></td>
                            </tr>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco recordlevelelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens2)->globaluniqueidentifier<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->idtypes<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->idinstitutioncode<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->idownerinstitution<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->idcollectioncode<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->iddataset<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->rights<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->rightsholder<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->accessrights<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->bibliographiccitation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->informationwithheld<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->datageneralizations<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->dynamicproperties<>"")
//
//
//                                        ) {

                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objRegister<?php echo $idinteractionelement."2"; ?>')" >Record level elements</a>
                                    <div  id='objRegister<?php echo $idinteractionelement."2"; ?>' STYLE='display:none;'  >

                                        <table width="100%">


                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->globaluniqueidentifier<>"") { ?>

                                            <tr>
                                                <td width="30%" >Global unique identifier</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->globaluniqueidentifier); ?></td>
                                            </tr>

                                                                <?php //} ?>


                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->idtypes<>"") { ?>

                                            <tr>
                                                <td width="30%" >Type</td>
                                                <td><?php //echo CHtml::encode(types::model()->findByPk($recordlevelelements->findByPk($model->idspecimens2)->idtypes)->types); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->idinstitutioncode<>"") { ?>

                                            <tr>
                                                <td width="30%" >Institution code</td>
                                                <td><?php //echo CHtml::encode(institutioncodes::model()->findByPk($recordlevelelements->findByPk($model->idspecimens2)->idinstitutioncode)->institutioncode); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->idownerinstitution<>"") { ?>

                                            <tr>
                                                <td width="30%" >Owner Institution code</td>
                                                <td><?php //echo CHtml::encode(ownerinstitution::model()->findByPk($recordlevelelements->findByPk($model->idspecimens2)->idownerinstitution)->ownerinstitution); ?></td>
                                            </tr>

                                                                <?php //} ?>


                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->idcollectioncode<>"") { ?>

                                            <tr>
                                                <td width="30%" >Collection code</td>
                                                <td><?php //echo CHtml::encode(collectioncodes::model()->findByPk($recordlevelelements->findByPk($model->idspecimens2)->idcollectioncode)->collectioncode); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->dataset->dataset<>"") { ?>

                                            <tr>
                                                <td width="30%" >Data set</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->dataset->dataset); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->rights<>"") { ?>

                                            <tr>
                                                <td width="30%" >Rights</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->rights); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->rightsholder<>"") { ?>

                                            <tr>
                                                <td width="30%" >Rights holder</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->rightsholder); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->rightsholder<>"") { ?>

                                            <tr>
                                                <td width="30%" >Access rights</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->accessrights); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->bibliographiccitation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Bibliographic citation</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->bibliographiccitation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->informationwithheld<>"") { ?>

                                            <tr>
                                                <td width="30%" >Information with held</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->informationwithheld); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->datageneralizations<>"") { ?>

                                            <tr>
                                                <td width="30%" >Data generalizations</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->datageneralizations); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->dynamicproperties<>"") { ?>

                                            <tr>
                                                <td width="30%" >Dynamic properties</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->dynamicproperties); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>

                                    </div>
                                </td>
                            </tr>


                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco occurrenceelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->recordnumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->catalognumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->othercatalognumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->occurrencedetails<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->preparation->preparation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->recordedby->recordedby<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->individual->individual<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->preparation->preparation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->associatedsequence->associatedsequence<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->occurrenceremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->individualcount<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->occurrencestatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->sex->sex<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->disposition->disposition<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->behavior->behavior<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->establishmentmean->establishmentmeans<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->reproductivecondition->reproductivecondition<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->lifestage->lifestage<>"")
//
//
//                                        ) {


                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objOcurrence<?php echo $idinteractionelement."2"; ?>')" >Occurrence Elements</a>

                                    <div  id='objOcurrence<?php echo $idinteractionelement."2"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->recordnumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Record number</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->recordnumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->catalognumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Catalog number</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->catalognumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->othercatalognumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Other catalog number</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->othercatalognumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->occurrencedetails<>"") { ?>

                                            <tr>
                                                <td width="30%" >Occurrence details</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->occurrencedetails); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->preparation->preparation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Preparation</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->preparation->preparation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->recordedby->recordedby<>"") { ?>

                                            <tr>
                                                <td width="30%" >Recorded by</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->recordedby->recordedby); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->individual->individual<>"") { ?>

                                            <tr>
                                                <td width="30%" >Individual</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->individual->individual); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->associatedsequence->associatedsequence<>"") { ?>

                                            <tr>
                                                <td width="30%" >Associated sequences</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->associatedsequence->associatedsequence); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->occurrenceremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Occurrence remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->occurrenceremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->individualcount<>"") { ?>

                                            <tr>
                                                <td width="30%" >Individual count</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->individualcount); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->occurrencestatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Occurrence status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->occurrencestatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->sex->sex<>"") { ?>

                                            <tr>
                                                <td width="30%" >Sex</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->sex->sex); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->disposition->disposition<>"") { ?>

                                            <tr>
                                                <td width="30%" >Disposition</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->disposition->disposition); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->establishmentmean->establishmentmeans<>"") { ?>

                                            <tr>
                                                <td width="30%" >Establishment means</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->establishmentmean->establishmentmeans); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->behavior->behavior<>"") { ?>

                                            <tr>
                                                <td width="30%" >Behavior</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->behavior->behavior); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->reproductivecondition->reproductivecondition<>"") { ?>

                                            <tr>
                                                <td width="30%" >Reproductive condition</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->reproductivecondition->reproductivecondition); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->reproductivecondition->reproductivecondition<>"") { ?>

                                            <tr>
                                                <td width="30%" >Life stage</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->occurrenceelement->lifestage->lifestage); ?></td>
                                            </tr>

                                                                <?php //} ?>


                                        </table>


                                    </div>
                                </td>
                            </tr>


                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco curatorialelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->typestatus->typestatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->identifiedby->identifiedby<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->associatedsequence->associatedsequence<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->preparation->preparation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->identifiedby->identifiedby<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->fieldnumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->individualcount<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->fieldnotes<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimeventdate<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimelevation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimdepth<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->dateidentified<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimdepth<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->disposition->disposition<>"")
//
//                                        ) {

                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objCuratorial<?php echo $idinteractionelement."2"; ?>')" >Curatorial Elements</a>

                                    <div  id='objCuratorial<?php echo $idinteractionelement."2"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->typestatus->typestatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Type status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->typestatus->typestatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->identifiedby->identifiedby<>"") { ?>

                                            <tr>
                                                <td width="30%" >identified by</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->identifiedby->identifiedby); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->associatedsequence->associatedsequence<>"") { ?>

                                            <tr>
                                                <td width="30%" >Associated sequences</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->associatedsequence->associatedsequence); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->preparation->preparation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Preparations</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->preparation->preparation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->fieldnumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Field number</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->fieldnumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->individualcount<>"") { ?>

                                            <tr>
                                                <td width="30%" >Individual count</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->individualcount); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->fieldnotes<>"") { ?>

                                            <tr>
                                                <td width="30%" >Field notes</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->fieldnotes); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimeventdate<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim event date</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimeventdate); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimelevation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim elevation</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimelevation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimdepth<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim depth</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->verbatimdepth); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->dateidentified<>"") { ?>

                                            <tr>
                                                <td width="30%" >Date identified</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->dateidentified); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->disposition->disposition<>"") { ?>

                                            <tr>
                                                <td width="30%" >Disposition</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->curatorialelement->disposition->disposition); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>


                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco identificationelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->identificationqualifier->identificationqualifier<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->identifiedby->identifiedby<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->typestatus->typestatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->identificationremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->dateidentified<>"")
//
//                                        ) {

                                            ?>


                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objidentification<?php echo $idinteractionelement."2"; ?>')" >identification elements</a>

                                    <div  id='objidentification<?php echo $idinteractionelement."2"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->identificationqualifier->identificationqualifier<>"") { ?>

                                            <tr>
                                                <td width="30%" >identification qualif.</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->identificationqualifier->identificationqualifier); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->identifiedby->identifiedby<>"") { ?>

                                            <tr>
                                                <td width="30%" >identified by</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->identifiedby->identifiedby); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->typestatus->typestatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Type status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->typestatus->typestatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->identificationremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >identification remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->identificationremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->dateidentified<>"") { ?>

                                            <tr>
                                                <td width="30%" >Data identified</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->identificationelement->dateidentified); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>

                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco eventelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens2)->eventelement->samplingprotocol->samplingprotocol<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->eventelement->samplingeffort<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->eventelement->habitat->habitat<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->eventelement->verbatimeventdate<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->eventelement->eventdate<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->eventelement->eventtime<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->eventelement->fieldnumber<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->eventelement->fieldnotes<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->eventelement->eventremarks<>"")
//
//                                        ) {

                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objEvent<?php echo $idinteractionelement."2"; ?>')" >Event elements</a>

                                    <div  id='objEvent<?php echo $idinteractionelement."2"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->eventelement->samplingprotocol->samplingprotocol<>"") { ?>

                                            <tr>
                                                <td width="30%" >Sampling protocol</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->eventelement->samplingprotocol->samplingprotocol); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->eventelement->samplingeffort<>"") { ?>

                                            <tr>
                                                <td width="30%" >Sampling effort</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->eventelement->samplingeffort); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->eventelement->habitat->habitat<>"") { ?>

                                            <tr>
                                                <td width="30%" >Habitat</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->eventelement->habitat->habitat); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->eventelement->verbatimeventdate<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim event date</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->eventelement->verbatimeventdate); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->eventelement->eventdate<>"") { ?>

                                            <tr>
                                                <td width="30%" >Event date</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->eventelement->eventdate); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->eventelement->eventtime<>"") { ?>

                                            <tr>
                                                <td width="30%" >Event time</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->eventelement->eventtime); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->eventelement->fieldnumber<>"") { ?>

                                            <tr>
                                                <td width="30%" >Field number</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->eventelement->fieldnumber); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->eventelement->fieldnotes<>"") { ?>

                                            <tr>
                                                <td width="30%" >Field notes</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->eventelement->fieldnotes); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->eventelement->eventremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Event remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->eventelement->eventremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>


                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco taxonomicelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->kingdom->kingdom<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->phylum->phylum<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->class->class<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->order->order<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->family->family<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->genus->genus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->subgenus->subgenus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->specificepithet->specificepithet<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonrank->taxonrank<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->scientificnameauthorship->scientificnameauthorship<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nomenclaturalcode->nomenclaturalcode<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->acceptednameusage->acceptednameusage<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->parentnameusage->parentnameusage<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->originalnameusage->originalnameusage<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nameaccordingto->nameaccordingto<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->originalnameusage->originalnameusage<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nameaccordingto->nameaccordingto<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->namepublishedin->namepublishedin<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonconcept->taxonconcept<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nomenclaturalstatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->vernacularname<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->verbatimtaxonrank<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonomicstatus->taxonomicstatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->verbatimtaxonrank<>"")
//
//
//                                        ) {

                                            ?>


                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objTaxonomy<?php echo $idinteractionelement."2"; ?>')" >Taxonomic elements</a>

                                    <div  id='objTaxonomy<?php echo $idinteractionelement."2"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->kingdom->kingdom<>"") { ?>

                                            <tr>
                                                <td width="30%" >Kingdom</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->kingdom->kingdom); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->phylum->phylum<>"") { ?>

                                            <tr>
                                                <td width="30%" >Phylum</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->phylum->phylum); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->class->class<>"") { ?>

                                            <tr>
                                                <td width="30%" >Class</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->class->class); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->order->order<>"") { ?>

                                            <tr>
                                                <td width="30%" >Order</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->order->order); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->family->family<>"") { ?>

                                            <tr>
                                                <td width="30%" >Family</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->family->family); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->genus->genus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Genus</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->genus->genus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->subgenus->subgenus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Sub genus</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->subgenus->subgenus); ?></td>
                                            </tr>

                                                                <?php //} ?>


                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->specificepithet->specificepithet<>"") { ?>

                                            <tr>
                                                <td width="30%" >Specific epithet</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->specificepithet->specificepithet); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->infraspecificepithet->infraspecificepithet<>"") { ?>

                                            <tr>
                                                <td width="30%" >Infra specific epithet</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->infraspecificepithet->infraspecificepithet); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonrank->taxonrank<>"") { ?>

                                            <tr>
                                                <td width="30%" >Taxon rank</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonrank->taxonrank); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->scientificnameauthorship->scientificnameauthorship<>"") { ?>

                                            <tr>
                                                <td width="30%" >Scientific name authorship</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->scientificnameauthorship->scientificnameauthorship); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nomenclaturalcode->nomenclaturalcode<>"") { ?>

                                            <tr>
                                                <td width="30%" >Nomenclatural code</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nomenclaturalcode->nomenclaturalcode); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->acceptednameusage->acceptednameusage<>"") { ?>

                                            <tr>
                                                <td width="30%" >Accepted name usage</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->acceptednameusage->acceptednameusage); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->parentnameusage->parentnameusage<>"") { ?>

                                            <tr>
                                                <td width="30%" >Parent name usage</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->parentnameusage->parentnameusage); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->originalnameusage->originalnameusage<>"") { ?>

                                            <tr>
                                                <td width="30%" >Original name usage</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->originalnameusage->originalnameusage); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nameaccordingto->nameaccordingto<>"") { ?>

                                            <tr>
                                                <td width="30%" >Name according to</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nameaccordingto->nameaccordingto); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->namepublishedin->namepublishedin<>"") { ?>

                                            <tr>
                                                <td width="30%" >Name published in</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->namepublishedin->namepublishedin); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonconcept->taxonconcept<>"") { ?>

                                            <tr>
                                                <td width="30%" >Taxon concept</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonconcept->taxonconcept); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nomenclaturalstatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Nomenclatural status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->nomenclaturalstatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->vernacularname<>"") { ?>

                                            <tr>
                                                <td width="30%" >Vernacular name</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->vernacularname); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->verbatimtaxonrank<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbation taxon rank</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->verbatimtaxonrank); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonomicstatus->taxonomicstatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Taxonomic status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonomicstatus->taxonomicstatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Taxon remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->taxonomicelement->taxonremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>


                                    </div>
                                </td>
                            </tr>


                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco locality elements

//                                        if(($recordlevelelements->findByPk($model->idspecimens2)->localityelement->continent->continent<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->waterbody->waterbody<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->islandgroup->islandgroup<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->island->island<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->country->country<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->municipality->municipality<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->locality->locality<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->georeferenceverificationstatus->georeferenceverificationstatus<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->habitat->habitat<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->minimumelevationinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->maximumelevationinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->minimumdepthinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->maximumdepthinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->minimumdistanceabovesurficeinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->maximumdistanceabovesurficeinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->locationaccordingto<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->locationremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimdepth<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimelevation<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimlocality<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->coordinateprecision<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->footprintsrs<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimsrs<>"")
//
//                                        ) {

                                            ?>


                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objLocality<?php echo $idinteractionelement."2"; ?>')" >Locality elements</a>

                                    <div  id='objLocality<?php echo $idinteractionelement."2"; ?>'  STYLE='display:none;'   >

                                        <table width="100%">

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->continent->continent<>"") { ?>

                                            <tr>
                                                <td width="30%" >Continent</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->continent->continent); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->waterbody->waterbody<>"") { ?>

                                            <tr>
                                                <td width="30%" >Water body</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->waterbody->waterbody); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->islandgroup->islandgroup<>"") { ?>

                                            <tr>
                                                <td width="30%" >Island group</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->islandgroup->islandgroup); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->island->island<>"") { ?>

                                            <tr>
                                                <td width="30%" >Island</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->island->island); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->country->country<>"") { ?>

                                            <tr>
                                                <td width="30%" >Country</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->country->country); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->municipality->municipality<>"") { ?>

                                            <tr>
                                                <td width="30%" >Municipality</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->municipality->municipality); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->locality->locality<>"") { ?>

                                            <tr>
                                                <td width="30%" >Locality</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->locality->locality); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->georeferenceverificationstatus->georeferenceverificationstatus<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verification status</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->georeferenceverificationstatus->georeferenceverificationstatus); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->habitat->habitat<>"") { ?>

                                            <tr>
                                                <td width="30%" >Habitat</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->habitat->habitat); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->minimumelevationinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Minimum elevation in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->minimumelevationinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->maximumelevationinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Maximum elevation in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->maximumelevationinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->minimumdepthinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Minimum depth in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->minimumdepthinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->maximumdepthinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Maximum depth in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->maximumdepthinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->minimumdistanceabovesurficeinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Minimum distance above surfice in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->minimumdistanceabovesurficeinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->maximumdistanceabovesurficeinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Maximum distance above surfice in meters</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->maximumdistanceabovesurficeinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->locationaccordingto<>"") { ?>

                                            <tr>
                                                <td width="30%" >Location according to</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->locationaccordingto); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->locationremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Location remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->locationremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimdepth<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim depth</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimdepth); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimelevation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim elevation</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimelevation); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimlocality<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim locality</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimlocality); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->coordinateprecision<>"") { ?>

                                            <tr>
                                                <td width="30%" >Cordinate precision</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->coordinateprecision); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->footprintsrs<>"") { ?>

                                            <tr>
                                                <td width="30%" >Footprint SRS</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->footprintsrs); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimsrs<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim SRS</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->localityelement->verbatimsrs); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>


                                            <?php //} ?>

                                        <?php
                                        //Verificando se há campos preenchidos no bloco geospatialelements

//                                        if(($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->decimallongitude<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->decimallatitude<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->coordinateuncertaintyinmeters<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->geodeticdatum<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->pointradiusspatialfit<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimcoordinates<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimlatitude<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimlongitude<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimcoordinatesystem<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->georeferenceprotocol<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->georeferencesource<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->georeferenceremarks<>"")||
//                                                ($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->footprintwkt<>"")
//
//                                        ) {

                                            ?>

                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objGeospatial<?php echo $idinteractionelement."2"; ?>')" >Geospatial elements</a>

                                    <div  id='objGeospatial<?php echo $idinteractionelement."2"; ?>'  STYLE='display:none;'   >

                                        <table width="100%" >

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->decimallongitude<>"") { ?>

                                            <tr>
                                                <td width="30%" >Decimal longitude</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->decimallongitude); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->decimallatitude<>"") { ?>

                                            <tr>
                                                <td width="30%" >Decimal latitude</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->decimallatitude); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->coordinateuncertaintyinmeters<>"") { ?>

                                            <tr>
                                                <td width="30%" >Coordinate uncertainty</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->coordinateuncertaintyinmeters); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->geodeticdatum<>"") { ?>

                                            <tr>
                                                <td width="30%" >Geodetic datum</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->geodeticdatum); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->pointradiusspatialfit<>"") { ?>

                                            <tr>
                                                <td width="30%" >Point radious spatial fit</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->pointradiusspatialfit); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimcoordinates<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim coordinates</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimcoordinates); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimlatitude<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim latitude</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimlatitude); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimlongitude<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim longitude</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimlongitude); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimcoordinatesystem<>"") { ?>

                                            <tr>
                                                <td width="30%" >Verbatim coordinate system</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->verbatimcoordinatesystem); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->georeferenceprotocol<>"") { ?>

                                            <tr>
                                                <td width="30%" >Georeference protocol</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->georeferenceprotocol); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->georeferencesource->georeferencesource<>"") { ?>

                                            <tr>
                                                <td width="30%" >Georeference sources</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->georeferencesource->georeferencesource); ?></td>
                                            </tr>

                                                                <?php //} ?>



                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->georeferenceremarks<>"") { ?>

                                            <tr>
                                                <td width="30%" >Georeference remarks</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->georeferenceremarks); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->footprintwkt<>"") { ?>

                                            <tr>
                                                <td width="30%" >Footprint WKT</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->footprintwkt); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                                            <?php //if($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->footprintspatialfit<>"") { ?>

                                            <tr>
                                                <td width="30%" >Footprint spatial fit</td>
                                                <td><?php //echo CHtml::encode($recordlevelelements->findByPk($model->idspecimens2)->geospatialelement->footprintspatialfit); ?></td>
                                            </tr>

                                                                <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>

                                            <?php //} ?>

                            <tr>
                                <td><strong>Interaction</strong></td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="javascript:controleExibicao('objInteraction<?php echo $idinteractionelement; ?>')" > Elementos de interação</a>
                                    <div  id='objInteraction<?php echo $idinteractionelement; ?>'   STYLE='display:none;'  >
                                        <table width="100%">

                                                        <?php //if($interactiontypes->findByPk($model->idinteractiontype)->interactiontype<>"") { ?>

                                            <tr>
                                                <td width="30%" >Interaction type</td>
                                                <td><?php //echo CHtml::encode($interactiontypes->findByPk($model->idinteractiontype)->interactiontype); ?></td>
                                            </tr>

                                                            <?php //} ?>

                                                        <?php //if($model->interactionrelatedinformation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Interaction related information</td>
                                                <td><?php //echo CHtml::encode($model->interactionrelatedinformation); ?></td>
                                            </tr>

                                                            <?php //} ?>


                                                        <?php //if($model->interactionrelatedinformation<>"") { ?>

                                            <tr>
                                                <td width="30%" >Related information</td>
                                                <td><?php //echo CHtml::encode($model->interactionrelatedinformation); ?></td>
                                            </tr>

                                                            <?php //} ?>

                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>-->
