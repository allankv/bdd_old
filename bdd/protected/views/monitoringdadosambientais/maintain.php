<?php echo CHtml::activeHiddenField($monitoring,'idmonitoring');?>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
    <div class="tablerow" id='divculture'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->culture, 'culture');?>
                <?php echo CHtml::label(Yii::t('yii','Cultura'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=culture',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring,'idculture');?>
                    <?php echo CHtml::activeTextField($monitoring->culture, 'culture', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteCulture"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcultivar'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->cultivar, 'cultivar');?>
                <?php echo CHtml::label(Yii::t('yii','Cultivar'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=cultivar',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring,'idcultivar');?>
                    <?php echo CHtml::activeTextField($monitoring->cultivar, 'cultivar', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteCultivar"></td>
        </tr>
    </div>
    <div class="tablerow" id='divsurroundingsculture'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->surroundingsculture, 'surroundingsculture');?>
                <?php echo CHtml::label(Yii::t('yii','Vegeta‹o Pr—xima'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=surroundingsculture',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring,'idsurroundingsculture');?>
                    <?php echo CHtml::activeTextField($monitoring->surroundingsculture, 'surroundingsculture', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSurroundingsCulture"></td>
        </tr>
    </div>
    <div class="tablerow" id='divpredominantbiome'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->predominantbiome, 'predominantbiome');?>
                <?php echo CHtml::label(Yii::t('yii','Bioma Predominante'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=predominantbiome',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring,'idpredominantbiome');?>
                    <?php echo CHtml::activeTextField($monitoring->predominantbiome, 'predominantbiome', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompletePredominantBiome"></td>
        </tr>
    </div>
</table>
