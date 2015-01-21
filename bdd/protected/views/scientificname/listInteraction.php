<h2><?php echo Yii::t('yii', "Scientific names list");?></h2>

<div class="actionBar">
<!-- 
[<?php //echo CHtml::link('New scientificnames',array('create')); ?>]
[<?php //echo CHtml::link('Manage scientificnames',array('admin')); ?>]
 -->
</div>

<?php //$this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php if(($_GET["formIdKingdom"]<>"")||($_GET["formIdPhylum"]<>"")||($_GET["formIdClass"]<>"")||($_GET["formIdOrder"]<>"")||($_GET["formIdFamily"]<>"")||($_GET["formIdGenus"]<>"")||($_GET["formIdSpecificEpithet"]<>"")||($_GET["formIdInfraEspecificEpithet"]<>"")||($_GET["formIdScientificName"]<>"")){ ?>
<?php echo Yii::t('yii', "View");?> : <a href="#" onclick="carregarPagina('index.php?r=scientificnames/list'+concatenarValoresUrlTaxonomicElements())" ><?php echo Yii::t('yii', "Filtered");?></a> &nbsp; <a href="#" onclick="carregarPagina('index.php?r=scientificnames/list&filtrar=no'+concatenarValoresUrlTaxonomicElements())" ><?php echo Yii::t('yii', "All");?></a>
<?php }?>

<?php 
	
	if ($scientificnamesList==null){
?>
	<div class="item" style="text-align: center;">
		<?php echo Yii::t('yii', "No record was found");?>		
		<?php 
			if ($_GET["filtrar"]=="")
			{
				?>
				 <?php echo Yii::t('yii', "suggested to be completed based on the values");?> <br><br>
				 <a href="#" onclick="carregarPagina('index.php?r=scientificnames/list&filtrar=no'+concatenarValoresUrlTaxonomicElements())" ><?php echo Yii::t('yii', "Click here to see all the values");?></a>
				<?php 
			}	
		?>						
	</div>
<?php 		
	}
?>

<?php foreach($scientificnamesList as $n=>$model): ?>
<div class="item">
<!--
<?php //echo CHtml::encode($model->getAttributeLabel('idscientificname')); ?>:
<?php //echo CHtml::link($model->idscientificname,array('show','id'=>$model->idscientificname)); ?>
<br/>
<?php //echo CHtml::encode($model->getAttributeLabel('scientificname')); ?>:
<?php //echo CHtml::encode($model->scientificname); ?>
-->
 
	<table style="width: 90%;">
	<tr>
		<td  > 
		<?php echo CHtml::encode($model->scientificname); ?>
		</td>
		<td style="text-align: right;" >
		&nbsp;&nbsp;<a href="#"  onclick="selecionaItemInteractionElements('taxonomicelement','<?php echo CHtml::encode($model->scientificname); ?>',<?php echo CHtml::encode($model->idscientificname); ?>,'<?php echo $_GET["filtrar"]; ?>');" rel="selecionaritem" ><?php echo Yii::t('yii', "Select");?></a>
		<?php //echo CHtml::link("Selecionar","#"); ?>
		</td>
	</tr>
	</table>

</div>
<?php endforeach; ?>
<br/>
<?php //$this->widget('CLinkPager',array('pages'=>$pages)); ?>
