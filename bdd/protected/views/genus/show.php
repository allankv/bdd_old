<h2>View genus <?php echo $genus->idgenus; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('genus List',array('list')); ?>]
[<?php echo CHtml::link('New genus',array('create')); ?>]
[<?php echo CHtml::link('Update genus',array('update','id'=>$genus->idgenus)); ?>]
[<?php echo CHtml::linkButton('Delete genus',array('submit'=>array('delete','id'=>$genus->idgenus),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage genus',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($genus->getAttributeLabel('genus')); ?>
</th>
    <td><?php echo CHtml::encode($genus->genus); ?>
</td>
</tr>
</table>
