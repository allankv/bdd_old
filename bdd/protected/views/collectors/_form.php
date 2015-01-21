<div class="yiiForm" style="background-color: transparent; border: none;">
<?php echo CHtml::beginForm(); ?>

    <div class="label2newbox">
        <?php echo Yii::t('yii', "Fields with * are required.");?>
    </div>

    <div class="tablenewbox">
        <div class="tablerownewbox">
            <?php echo CHtml::errorSummary($collectors); ?>

                <div class="tablelabelcelnewbox">
                    <div class="labelnewbox">
                        <?php //echo CHtml::activeLabelEx($collectors,'collector');
                        echo CHtml::label(Yii::t('yii','Collector'), "collectors");
                        ?>
                        <span class="required">*</span>
                    </div>
                </div>
        </div>
        <div class="tablerownewbox">
                <div class="tablefieldcelnewbox">
                    <div class="fieldnewbox">
                        <?php echo CHtml::activeTextField($collectors,'collector',array('size'=>48)); ?>
                    </div>
                </div>

        </div>
    </div>

    <div class="actionnewbox">
	<?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
        <input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataCollectingEventElements($('#collector'),$('#collectors_idcollector'),'index.php?r=collectors/create'+concatenarValoresUrlCollectingEventElements(),'collector='+document.getElementById('collectors_collector').value)" >
    </div>

<?php echo CHtml::endForm(); ?>
</div><!-- yiiForm -->