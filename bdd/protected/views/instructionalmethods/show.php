<h2>View instructionalmethods <?php echo $model->idinstructionalmethods; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('instructionalmethods List',array('list')); ?>]
[<?php echo CHtml::link('New instructionalmethods',array('create')); ?>]
[<?php echo CHtml::link('Update instructionalmethods',array('update','id'=>$model->idinstructionalmethods)); ?>]
[<?php echo CHtml::linkButton('Delete instructionalmethods',array('submit'=>array('delete','id'=>$model->idinstructionalmethods),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage instructionalmethods',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('instrumentalmethod')); ?>
</th>
    <td><?php echo CHtml::encode($model->instrumentalmethod); ?>
</td>
</tr>
</table>
