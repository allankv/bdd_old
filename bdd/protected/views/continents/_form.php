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
            <?php echo CHtml::errorSummary($continents); ?>

            <div class="tablelabelcelnewbox">
                <div class="labelnewbox">
                    <?php //echo CHtml::activeLabelEx($continents,'continent');
                    echo CHtml::label(Yii::t('yii','Continent'), "continents");
                    ?>
                    
                </div>
            </div>
        </div>
        <div class="tablerownewbox">
            <div class="tablefieldcelnewbox">
                <div class="fieldnewbox">
                    <?php echo CHtml::activeTextField($continents,'continent',array('size'=>48)); ?>
                </div>
            </div>

        </div>
    </div>

    <div class="actionnewbox">
        <?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
        <input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataLocalityElements($('#continent'),$('#localityelements_idcontinent'),'index.php?r=continents/create','continent='+document.getElementById('continents_continent').value)" >
    </div>

</div><!-- yiiForm -->