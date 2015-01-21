<h2>View collectedby <?php echo $model->idcollectedby; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('collectedby List',array('list')); ?>]
[<?php echo CHtml::link('New collectedby',array('create')); ?>]
[<?php echo CHtml::link('Update collectedby',array('update','id'=>$model->idcollectedby)); ?>]
[<?php echo CHtml::linkButton('Delete collectedby',array('submit'=>array('delete','id'=>$model->idcollectedby),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage collectedby',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('collectedby')); ?>
</th>
    <td><?php echo CHtml::encode($model->collectedby); ?>
</td>
</tr>
</table>
