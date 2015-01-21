<h2>institutioncodes List</h2>

<div class="actionBar">
<!-- 
[<?php //echo CHtml::link('New institutioncodes',array('create')); ?>]
[<?php //echo CHtml::link('Manage institutioncodes',array('admin')); ?>]
 -->
</div>

<?php //$this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($institutioncodesList as $n=>$model): ?>
<div class="item">
<!-- 
<?php //echo CHtml::encode($model->getAttributeLabel('idinstitutioncode')); ?>:
<?php //echo CHtml::link($model->idinstitutioncode,array('show','id'=>$model->idinstitutioncode)); ?>
<br/>
<?php //echo CHtml::encode($model->getAttributeLabel('institutioncode')); ?>:
<?php //echo CHtml::encode($model->institutioncode); ?>
<br/>
 -->
 
 	<table style="width: 90%;">
	<tr>
		<td  > 
		<?php echo CHtml::encode($model->institutioncode); ?>
		</td>
		<td style="text-align: right;" >
		&nbsp;&nbsp;<a href="#"  onclick="selecionaItemInteractionElements('institutioncode','<?php echo CHtml::encode($model->institutioncode); ?>',<?php echo CHtml::encode($model->idinstitutioncode); ?>);" rel="selecionaritem" >Selecionar</a>
		<?php //echo CHtml::link("Selecionar","#"); ?>
		</td>
	</tr>
	</table>

</div>
<?php endforeach; ?>
<br/>
<?php //$this->widget('CLinkPager',array('pages'=>$pages)); ?>