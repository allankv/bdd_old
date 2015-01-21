<h2><?php echo Yii::t('yii', "Basis of record list");?></h2>

<div class="actionBar">
<!-- 
[<?php //echo CHtml::link('New basisofrecords',array('create')); ?>]
[<?php //echo CHtml::link('Manage basisofrecords',array('admin')); ?>]
 -->
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($basisofrecordsList as $n=>$model): ?>
<div class="item">
<!-- 
<?php //echo CHtml::encode($model->getAttributeLabel('idbasisofrecord')); ?>:
<?php //echo CHtml::link($model->idbasisofrecord,array('show','id'=>$model->idbasisofrecord)); ?>
<br/>
<?php //echo CHtml::encode($model->getAttributeLabel('basisofrecord')); ?>:
<?php //echo CHtml::encode($model->basisofrecord); ?>
<br/>
 -->

 	<table style="width: 90%;">
	<tr>
		<td  > 
		<?php echo CHtml::encode($model->basisofrecord); ?>
		</td>
		<td style="text-align: right;" >
		&nbsp;&nbsp;<a href="#"  onclick="selecionaItemRecordLevelElements('basisofrecord','<?php echo CHtml::encode($model->basisofrecord); ?>',<?php echo CHtml::encode($model->idbasisofrecord); ?>);" rel="selecionaritem" ><?php echo Yii::t('yii', "Select");?></a>
		<?php //echo CHtml::link("Selecionar","#"); ?>
		</td>
	</tr>
	</table>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>