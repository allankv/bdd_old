<h2>View institutioncodes <?php echo $institutioncodes->idinstitutioncode; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('institutioncodes List',array('list')); ?>]
[<?php echo CHtml::link('New institutioncodes',array('create')); ?>]
[<?php echo CHtml::link('Update institutioncodes',array('update','id'=>$institutioncodes->idinstitutioncode)); ?>]
[<?php echo CHtml::linkButton('Delete institutioncodes',array('submit'=>array('delete','id'=>$institutioncodes->idinstitutioncode),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage institutioncodes',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($institutioncodes->getAttributeLabel('institutioncode')); ?>
</th>
    <td><?php echo CHtml::encode($institutioncodes->institutioncode); ?>
</td>
</tr>
</table>
