<h2>View highergeograph <?php echo $model->idhighergeograph; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('highergeograph List',array('list')); ?>]
[<?php echo CHtml::link('New highergeograph',array('create')); ?>]
[<?php echo CHtml::link('Update highergeograph',array('update','id'=>$model->idhighergeograph)); ?>]
[<?php echo CHtml::linkButton('Delete highergeograph',array('submit'=>array('delete','id'=>$model->idhighergeograph),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage highergeograph',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('highergeographid')); ?>
</th>
    <td><?php echo CHtml::encode($model->highergeographid); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('highergeograph')); ?>
</th>
    <td><?php echo CHtml::encode($model->highergeograph); ?>
</td>
</tr>
</table>
