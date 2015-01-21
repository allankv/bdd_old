<div class="yiiForm" style="background-color: transparent; border: none;">
<?php echo CHtml::beginForm(); ?>

    <div class="label2newbox">
        <?php echo Yii::t('yii', "Fields with * are required.");?>
    </div>

    <div class="tablenewbox">
        <div class="tablerownewbox">
            <?php echo CHtml::errorSummary($infraspecificranks); ?>

                <div class="tablelabelcelnewbox">
                    <div class="labelnewbox">
                        <?php //echo CHtml::activeLabelEx($infraspecificranks,'infraspecificrank');
                        echo CHtml::label(Yii::t('yii','Infraspecific rank'), "infraspecificranks");
                        ?>
                        <span class="required">*</span>
                    </div>
                </div>
        </div>
        <div class="tablerownewbox">
                <div class="tablefieldcelnewbox">
                    <div class="fieldnewbox">
                        <?php echo CHtml::activeTextField($infraspecificranks,'infraspecificrank',array('rows'=>6, 'cols'=>50, 'size'=>48)); ?>
                    </div>
                </div>

        </div>
    </div>

    <div class="actionnewbox">
	<?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
        <input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataTaxonomicElements($('#infraspecificrank'),$('#taxonomicelements_idinfraspecificrank'),'index.php?r=infraspecificranks/create'+concatenarValoresUrlTaxonomicElements(),'infraspecificrank='+document.getElementById('infraspecificranks_infraspecificrank').value)" >
    </div>

<?php echo CHtml::endForm(); ?>
</div><!-- yiiForm -->