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
            <?php echo CHtml::errorSummary($model); ?>

                <div class="tablelabelcelnewbox">
                    <div class="labelnewbox">

                    <?php echo CHtml::label(Yii::t('yii','Accepted name usage'), "acceptednameusage",  array());?>
                    
                    </div>
                </div>
        </div>
        <div class="tablerownewbox">
                <div class="tablefieldcelnewbox">
                    <div class="fieldnewbox">
                        <?php echo CHtml::activeTextField($model,'acceptednameusage',array('rows'=>6, 'cols'=>50, 'size'=>48)); ?>
                    </div>
                </div>

        </div>
    </div>

    <div class="actionnewbox">

            <?php
            /*echo CHtml::ajaxSubmitButton('Create','',
		array('success'=>"alert('funfou o ajax')")
            );*/
            ?>

            <input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataTaxonomicElements($('#acceptednameusage'),$('#taxonomicelements_idacceptednameusage'),'index.php?r=acceptednameusage/create'+concatenarValoresUrlTaxonomicElements(),'acceptednameusage='+document.getElementById('acceptednameusage_acceptednameusage').value)" >
            <?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
   </div>

</div><!-- yiiForm -->