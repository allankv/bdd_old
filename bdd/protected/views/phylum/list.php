<div class="table" style="width: 554px; background-color: #F4F4F4; margin-top:10px; margin-bottom:10px; -moz-border-radius-topleft: 1.0em; -moz-border-radius-topright: 1.0em; -moz-border-radius-bottomleft: 1.0em; -moz-border-radius-bottomright: 1.0em; border: 1px solid #ccc;">
    <div style="width: 554px; height: 80px;">
        <div>
        <?php echo CHtml::image("images/help/iconelist.png","",array("style"=>"padding-left: 30px; padding-top: 20px ; float: left;")); ?>
            <div style="padding-left: 30px; padding-top: 20px ; float: left; color: #535353; font-size: 24px; font-family: Verdana;">
                <?php echo Yii::t('yii', "Phylums List");?>
            </div>
        </div>
    </div>

    <div style="width: 90%;padding-left: 30px; padding-bottom: 8px;" align="left">
        <?php if(($_GET["formIdKingdom"]<>"")||($_GET["formIdPhylum"]<>"")||($_GET["formIdClass"]<>"")||($_GET["formIdOrder"]<>"")||($_GET["formIdFamily"]<>"")||($_GET["formIdGenus"]<>"")||($_GET["formIdSpecificEpithet"]<>"")||($_GET["formIdInfraEspecificEpithet"]<>"")||($_GET["formIdScientificName"]<>"")){ ?>
        <?php echo Yii::t('yii', "View");?> : <a href="#" onclick="carregarPagina('index.php?r=phylums/list'+concatenarValoresUrlTaxonomicElements())" ><?php echo Yii::t('yii', "Filtered");?></a> &nbsp;  <a href="#" onclick="carregarPagina('index.php?r=phylums/list&filtrar=no'+concatenarValoresUrlTaxonomicElements())" ><?php echo Yii::t('yii', "All");?></a>
        <?php }?>
    </div>

    <table style="width: 90%; border-top: 5px solid #CCCCCC; border-bottom: 5px solid #CCCCCC;" align="center" cellpadding="0" cellspacing="0">
        

        <?php

            if ($phylumsList==null){
        ?>
            <div class="item" style="text-align: center;">
		<?php echo Yii::t('yii', "No record was found");?>
		<?php
			if ($_GET["filtrar"]=="")
			{
				?>
				 <?php echo Yii::t('yii', "suggested to be completed based on the values");?> <br><br>
				 <a href="#" onclick="carregarPagina('index.php?r=phylums/list&filtrar=no'+concatenarValoresUrlTaxonomicElements())" ><?php echo Yii::t('yii', "Click here to see all the values");?></a>
				<?php
			}
		?>
            </div>
        <?php
	}
        ?>

        <?php foreach($phylumsList as $n=>$model): ?>
        <!--
        <?php // echo CHtml::encode($model->getAttributeLabel('idphylum')); ?>:
        <?php // echo CHtml::link($model->idphylum,array('show','id'=>$model->idphylum)); ?>
        <br/>
        <?php // echo CHtml::encode($model->getAttributeLabel('phylum')); ?>:
        <?php //echo CHtml::encode($model->phylum); ?>
        -->


	<tr style="width:500px; height: 30px;">
		<td style="border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;">
                    <span style="padding-left: 10px;"> <?php echo CHtml::encode($model->phylum); ?> </span>
		</td>
		<td style="text-align: center; border-bottom: 1px solid #CCCCCC; width: 100px;" >
		&nbsp;&nbsp<a href="#"  onclick="selecionaItemTaxonomicElements('phylum','<?php echo CHtml::encode($model->phylum); ?>',<?php echo CHtml::encode($model->idphylum); ?>,'<?php echo $_GET["filtrar"];?>');" rel="selecionaritem" ><?php echo Yii::t('yii', "Select");?></a>
		<?php //echo CHtml::link("Selecionar","#"); ?>

		</td>
	</tr>

        <?php endforeach; ?>
    </table>
    <br>
</div>