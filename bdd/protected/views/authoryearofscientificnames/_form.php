<div class="yiiForm" style="background-color: transparent; border: none;">
<?php echo CHtml::beginForm(); ?>

    <div class="label2newbox">
        <?php echo Yii::t('yii', "Fields with * are required.");?>
    </div>

    <div class="tablenewbox">
        <div class="tablerownewbox">
            <?php echo CHtml::errorSummary($authoryearofscientificnames); ?>

                <div class="tablelabelcelnewbox">
                    <div class="labelnewbox">
                        <?php //echo CHtml::activeLabelEx($authoryearofscientificnames,'authoryearofscientificname');
                        echo CHtml::label(Yii::t('yii','Author year scient. name'), "authoryearofscientificnames");
                        ?>
                        <span class="required">*</span>
                    </div>
                </div>
        </div>
        <div class="tablerownewbox">
                <div class="tablefieldcelnewbox">
                    <div class="fieldnewbox">
                        <?php echo CHtml::activeTextField($authoryearofscientificnames,'authoryearofscientificname',array('rows'=>6, 'cols'=>50, 'size'=>48)); ?>
                    </div>
                </div>

        </div>
    </div>

    <div class="actionnewbox">
	<?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
        <input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataTaxonomicElements($('#authoryearofscientificname'),$('#taxonomicelements_idauthoryearofscientificname'),'index.php?r=authoryearofscientificnames/create'+concatenarValoresUrlTaxonomicElements(),'authoryearofscientificname='+document.getElementById('authoryearofscientificnames_authoryearofscientificname').value)" >
    </div>

<?php echo CHtml::endForm(); ?>
</div><!-- yiiForm -->