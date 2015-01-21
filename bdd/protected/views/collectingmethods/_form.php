<div class="yiiForm" style="background-color: transparent; border: none;">
<?php echo CHtml::beginForm(); ?>

    <div class="label2newbox">
        <?php echo Yii::t('yii', "Fields with * are required.");?>
    </div>

    <div class="tablenewbox">
        <div class="tablerownewbox">
            <?php echo CHtml::errorSummary($collectingmethods); ?>

                <div class="tablelabelcelnewbox">
                    <div class="labelnewbox">
                        <?php //echo CHtml::activeLabelEx($collectingmethods,'collectingmethod');
                        echo CHtml::label(Yii::t('yii','Collecting method'), "collectingmethods");
                        ?>
                        <span class="required">*</span>
                    </div>
                </div>
        </div>
        <div class="tablerownewbox">
                <div class="tablefieldcelnewbox">
                    <div class="fieldnewbox">
                        <?php echo CHtml::activeTextField($collectingmethods,'collectingmethod',array('size'=>48)); ?>
                    </div>
                </div>

        </div>
    </div>

    <div class="actionnewbox">
	<?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
        <input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataCollectingEventElements($('#collectingmethod'),$('#collectingeventelements_idcollectingmethod'),'index.php?r=collectingmethods/create'+concatenarValoresUrlCollectingEventElements(),'collectingmethod='+document.getElementById('collectingmethods_collectingmethod').value)" >
    </div>

<?php echo CHtml::endForm(); ?>
</div><!-- yiiForm -->