<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_HEAD);	
$cs->registerScriptFile("js/lightbox/biologicalelements.js",CClientScript::POS_HEAD);
$cs->registerCssFile("css/lightbox.css");
?>

<div class="yiiForm">

    <p>
        <?php
        if($showActionButton)
            echo Yii::t('yii',"Fields with * are required.");
        ?>
    </p>

    <?php
    if($showActionButton)
        echo CHtml::beginForm(); ?>

    <?php
    if($showActionButton)
        echo CHtml::errorSummary($biologicalelements); ?>


    <div class="tablerow" id='divsex'>
        <div class="tablelabelcel">
            <div class="label">
                <?php echo CHtml::label(Yii::t('yii','Sex'), "biologicalelements"); ?>
            </div>
        </div>
        <div class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=sex',array('rel'=>'lightbox'));?>
        </div>
        <div class="tablefieldcel">
            <div class="field">
                <?php echo CHtml::activeDropDownList($biologicalelements, 'idsex', CHtml::listData(sexes::model()->findAll(), 'idsex', 'sex'), array('empty'=>'-')); ?>
            </div>
        </div>
    </div>

    <div class="tablerow" id='divlifestage'>
        <div class="tablelabelcel">
            <div class="label">
                <?php echo CHtml::label(Yii::t('yii','Life stage'), "biologicalelements");?>
            </div>
        </div>
        <div class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=lifestage',array('rel'=>'lightbox'));?>
        </div>
        <div class="tablefieldcel">
            <div class="field">
                <?php echo CHtml::activeDropDownList($biologicalelements, 'idlifestage', CHtml::listData(lifestages::model()->findAll(), 'idlifestage', 'lifestage'), array('empty'=>'-')); ?>
            </div>
        </div>
    </div>



    <div class="tablerow" id='divreproductivecondition'>
        <div class="tablelabelcel">
            <div class="label">
                <?php echo CHtml::label(Yii::t('yii','Reproductive Condition'), "biologicalelements");?>
            </div>
        </div>
        <div class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=reproductivecondition',array('rel'=>'lightbox'));?>
        </div>
        <div class="tablefieldcel">
            <div class="field">
                <?php echo CHtml::activeDropDownList($biologicalelements, 'idreproductivecondition', CHtml::listData(reproductivecondition::model()->findAll(), 'idreproductivecondition', 'reproductivecondition'), array('empty'=>'-')); ?>
            </div>
        </div>
    </div>


    <!--
            <div class="tablerow">
                <div class="tablelabelcel">
                    <div class="label">
    <?php// echo CHtml::label(Yii::t('yii','Attributes'), "biologicalelements");?>
                    </div>
                </div>
                <div class="tablemiddlecel">
    <?php //echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=attributes',array('rel'=>'lightbox'));?>
                </div>
                <div class="tablefieldcel">
                    <div class="field">
    <?php// echo CHtml::activeTextArea($biologicalelements,'attributes',array('rows'=>2, 'cols'=>40)); ?>
                    </div>
                </div>
            </div>-->

    <?php
    if($showActionButton) {
        echo "<div class=\"action\">";
        echo CHtml::submitButton($update ? Yii::t('yii', "Save") : Yii::t('yii', "Create"));
        echo "</div>";
    }
    ?>

    <?php
    if($showActionButton)
        echo CHtml::endForm(); ?>

</div><!-- yiiForm -->