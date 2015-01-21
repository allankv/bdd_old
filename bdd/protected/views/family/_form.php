<div class="yiiForm" style="background-color: transparent; border: none;">


    <div class="label2newbox">
        <div style="padding: 5px 0px 0px; position: relative; width: 60%;"><span style="color:red"><?php echo Yii::t('yii', "Notice:");?></span> <?php echo Yii::t('yii', "Before creating a new item, be sure that it is not registered in the data base!");?><br/>
            <?php echo Yii::t('yii', "Please visit the");?> <a href="index.php"><?php echo Yii::t('yii', "quality catalog");?></a><?php echo Yii::t('yii', " to check.");?>
        </div>
        <br/>
        <div style="padding: 0px 0px 10px 0px;">
        <?php //echo Yii::t('yii', "Fields with * are required.");?>
        </div>
    </div>

    <div class="tablenewbox">
        <div class="tablerownewbox">
            <?php echo CHtml::errorSummary($families); ?>

                <div class="tablelabelcelnewbox">
                    <div class="labelnewbox">
                        <?php //echo CHtml::activeLabelEx($families,'family');        
                        echo CHtml::label(Yii::t('yii','Family'), "families");
                        ?>
                        
                    </div>
                </div>
        </div>
        <div class="tablerownewbox">
                <div class="tablefieldcelnewbox">
                    <div class="fieldnewbox">
                        <?php echo CHtml::activeTextField($families,'family',array('rows'=>6, 'cols'=>50, 'size'=>48)); ?>
                    </div>
                </div>
                
        </div>
    </div>

    <div class="actionnewbox">
	<?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
        <input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataTaxonomicElements($('#family'),$('#taxonomicelements_idfamily'),'index.php?r=families/create'+concatenarValoresUrlTaxonomicElements(),'family='+document.getElementById('families_family').value)" >
    </div>

</div><!-- yiiForm -->