<h2>View diseases <?php echo $model->iddiseases; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('diseases List',array('list')); ?>]
[<?php echo CHtml::link('New diseases',array('create')); ?>]
[<?php echo CHtml::link('Update diseases',array('update','id'=>$model->iddiseases)); ?>]
[<?php echo CHtml::linkButton('Delete diseases',array('submit'=>array('delete','id'=>$model->iddiseases),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage diseases',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('deseases')); ?>
</th>
    <td><?php echo CHtml::encode($model->deseases); ?>
</td>
</tr>
</table>
