<h2>View previousidentification <?php echo $model->idpreviousidentification; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('previousidentification List',array('list')); ?>]
[<?php echo CHtml::link('New previousidentification',array('create')); ?>]
[<?php echo CHtml::link('Update previousidentification',array('update','id'=>$model->idpreviousidentification)); ?>]
[<?php echo CHtml::linkButton('Delete previousidentification',array('submit'=>array('delete','id'=>$model->idpreviousidentification),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage previousidentification',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('previousidentification')); ?>
</th>
    <td><?php echo CHtml::encode($model->previousidentification); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('idrecordlevelelements')); ?>
</th>
    <td><?php echo CHtml::encode($model->idrecordlevelelements); ?>
</td>
</tr>
</table>
