<h2><?php echo Yii::t('yii', "Valid distribution list");?></h2>

<div class="actionBar">
<!-- 
[<?php //echo CHtml::link('New validdistributionflags',array('create')); ?>]
[<?php //echo CHtml::link('Manage validdistributionflags',array('admin')); ?>]
</div>
 -->

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($validdistributionflagsList as $n=>$model): ?>
<div class="item">
<!-- 
<?php //echo CHtml::encode($model->getAttributeLabel('idvaliddistributionflag')); ?>:
<?php //echo CHtml::link($model->idvaliddistributionflag,array('show','id'=>$model->idvaliddistributionflag)); ?>
<br/>
<?php //echo CHtml::encode($model->getAttributeLabel('validdistributionflag')); ?>:
<?php //echo CHtml::encode($model->validdistributionflag); ?>
<br/>
 -->

	<table style="width: 90%;">
	<tr>
		<td  > 
		<?php echo CHtml::encode($model->validdistributionflag); ?>
		</td>
		<td style="text-align: right;" >
		&nbsp;&nbsp;<a href="#"  onclick="selecionaItemCollectingEventElements('validdistributionflag','<?php echo CHtml::encode($model->validdistributionflag); ?>',<?php echo CHtml::encode($model->idvaliddistributionflag); ?>);" rel="selecionaritem" ><?php echo Yii::t('yii', "Select");?></a>
		<?php //echo CHtml::link("Selecionar","#"); ?>
		</td>
	</tr>
	</table>


</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>