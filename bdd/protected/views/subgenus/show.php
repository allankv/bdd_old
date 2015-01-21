<h2>View subgenus <?php echo $model->idsubgenus; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('subgenus List',array('list')); ?>]
[<?php echo CHtml::link('New subgenus',array('create')); ?>]
[<?php echo CHtml::link('Update subgenus',array('update','id'=>$model->idsubgenus)); ?>]
[<?php echo CHtml::linkButton('Delete subgenus',array('submit'=>array('delete','id'=>$model->idsubgenus),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage subgenus',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('subgenus')); ?>
</th>
    <td><?php echo CHtml::encode($model->subgenus); ?>
</td>
</tr>
</table>
