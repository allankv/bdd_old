<h2>View acceptednameusage <?php echo $model->idacceptednameusage; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('acceptednameusage List',array('list')); ?>]
[<?php echo CHtml::link('New acceptednameusage',array('create')); ?>]
[<?php echo CHtml::link('Update acceptednameusage',array('update','id'=>$model->idacceptednameusage)); ?>]
[<?php echo CHtml::linkButton('Delete acceptednameusage',array('submit'=>array('delete','id'=>$model->idacceptednameusage),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage acceptednameusage',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('acceptednameusage')); ?>
</th>
    <td><?php echo CHtml::encode($model->acceptednameusage); ?>
</td>
</tr>
</table>
