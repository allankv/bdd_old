<div class="yiiForm" style="background-color: transparent; border: none;">
    <?php echo CHtml::beginForm(); ?>

    <div class="label2newbox">
        <?php echo Yii::t('yii', "Fields with * are required.");?>
    </div>

    <div class="tablenewbox">
        <div class="tablerownewbox">
            <?php echo CHtml::errorSummary($provider); ?>

            <div class="tablelabelcelnewbox">
                <div class="labelnewbox">
                    <?php //echo CHtml::activeLabelEx($provider,'provider');
                    echo CHtml::label(Yii::t('yii','Provider'), "provider");
                    ?>
                    <span class="required">*</span>
                </div>
            </div>
        </div>
        <div class="tablerownewbox">
            <div class="tablefieldcelnewbox">
                <div class="fieldnewbox">
                    <?php echo CHtml::activeTextField($provider,'provider',array('size'=>48)); ?>
                </div>
            </div>

        </div>
    </div>

    <div class="actionnewbox">
        <?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
        <input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataMedia($('#provider'),$('#media_idprovider'),'index.php?r=provider/create','provider='+document.getElementById('provider_provider').value)" >
    </div>

    <?php echo CHtml::endForm(); ?>
</div><!-- yiiForm -->