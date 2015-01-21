<h2>View typereferences <?php echo $model->idtypereferences; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('typereferences List',array('list')); ?>]
[<?php echo CHtml::link('New typereferences',array('create')); ?>]
[<?php echo CHtml::link('Update typereferences',array('update','id'=>$model->idtypereferences)); ?>]
[<?php echo CHtml::linkButton('Delete typereferences',array('submit'=>array('delete','id'=>$model->idtypereferences),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage typereferences',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('typereferences')); ?>
</th>
    <td><?php echo CHtml::encode($model->typereferences); ?>
</td>
</tr>
</table>
