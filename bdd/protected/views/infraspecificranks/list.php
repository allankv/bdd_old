<div class="table" style="width: 554px; background-color: #F4F4F4; margin-top:10px; margin-bottom:10px; -moz-border-radius-topleft: 1.0em; -moz-border-radius-topright: 1.0em; -moz-border-radius-bottomleft: 1.0em; -moz-border-radius-bottomright: 1.0em; border: 1px solid #ccc;">
    <div style="width: 554px; height: 80px;">
        <div>
        <?php echo CHtml::image("images/help/iconelist.png","",array("style"=>"padding-left: 30px; padding-top: 20px ; float: left;")); ?>
            <div style="padding-left: 30px; padding-top: 20px ; float: left; color: #535353; font-size: 24px; font-family: Verdana;">
                <?php echo Yii::t('yii', "Infra specific ranks List");?>
            </div>
        </div>
    </div>

    <table style="width: 90%; border-top: 5px solid #CCCCCC; border-bottom: 5px solid #CCCCCC;" align="center" cellpadding="0" cellspacing="0">
        <?php foreach($infraspecificranksList as $n=>$model): ?>
        <!--
        <?php //echo CHtml::encode($model->getAttributeLabel('idinfraspecificrank')); ?>:
        <?php //echo CHtml::link($model->idinfraspecificrank,array('show','id'=>$model->idinfraspecificrank)); ?>
        <br/>
        <?php //echo CHtml::encode($model->getAttributeLabel('infraspecificrank')); ?>:
        <?php //echo CHtml::encode($model->infraspecificrank); ?>
         -->


	<tr style="width:500px; height: 30px;">
		<td style="border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;">
                    <span style="padding-left: 10px;"> <?php echo CHtml::encode($model->infraspecificrank); ?> </span>
		</td>
		<td style="text-align: center; border-bottom: 1px solid #CCCCCC; width: 100px;" >
		&nbsp;&nbsp;<a href="#"  onclick="selecionaItemTaxonomicElements('infraspecificrank','<?php echo CHtml::encode($model->infraspecificrank); ?>',<?php echo CHtml::encode($model->idinfraspecificrank); ?>);" rel="selecionaritem" ><?php echo Yii::t('yii', "Select");?></a>
		<?php //echo CHtml::link("Selecionar","#"); ?>

		</td>
	</tr>

        <?php endforeach; ?>
    </table>
    <br>
</div>