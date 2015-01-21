<h2>View canonicalnames <?php echo $model->idcanonicalnames; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('canonicalnames List',array('list')); ?>]
[<?php echo CHtml::link('New canonicalnames',array('create')); ?>]
[<?php echo CHtml::link('Update canonicalnames',array('update','id'=>$model->idcanonicalnames)); ?>]
[<?php echo CHtml::linkButton('Delete canonicalnames',array('submit'=>array('delete','id'=>$model->idcanonicalnames),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage canonicalnames',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('idcanonicalauthorship')); ?>
</th>
    <td><?php echo CHtml::encode($model->idcanonicalauthorship); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('canonicalname')); ?>
</th>
    <td><?php echo CHtml::encode($model->canonicalname); ?>
</td>
</tr>
</table>
