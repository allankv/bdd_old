<h2>View contributors <?php echo $model->idcontributors; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('contributors List',array('list')); ?>]
[<?php echo CHtml::link('New contributors',array('create')); ?>]
[<?php echo CHtml::link('Update contributors',array('update','id'=>$model->idcontributors)); ?>]
[<?php echo CHtml::linkButton('Delete contributors',array('submit'=>array('delete','id'=>$model->idcontributors),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage contributors',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('contributor')); ?>
</th>
    <td><?php echo CHtml::encode($model->contributor); ?>
</td>
</tr>
</table>
