<h2>View migrations <?php echo $model->idmigration; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('migrations List',array('list')); ?>]
[<?php echo CHtml::link('New migrations',array('create')); ?>]
[<?php echo CHtml::link('Update migrations',array('update','id'=>$model->idmigration)); ?>]
[<?php echo CHtml::linkButton('Delete migrations',array('submit'=>array('delete','id'=>$model->idmigration),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage migrations',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('migration')); ?>
</th>
    <td><?php echo CHtml::encode($model->migration); ?>
</td>
</tr>
</table>
