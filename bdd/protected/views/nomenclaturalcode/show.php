<h2>View nomenclaturalcodes <?php echo $nomenclaturalcodes->idnomenclaturalcode; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('nomenclaturalcodes List',array('list')); ?>]
[<?php echo CHtml::link('New nomenclaturalcodes',array('create')); ?>]
[<?php echo CHtml::link('Update nomenclaturalcodes',array('update','id'=>$nomenclaturalcodes->idnomenclaturalcode)); ?>]
[<?php echo CHtml::linkButton('Delete nomenclaturalcodes',array('submit'=>array('delete','id'=>$nomenclaturalcodes->idnomenclaturalcode),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage nomenclaturalcodes',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($nomenclaturalcodes->getAttributeLabel('nomenclaturalcode')); ?>
</th>
    <td><?php echo CHtml::encode($nomenclaturalcodes->nomenclaturalcode); ?>
</td>
</tr>
</table>
