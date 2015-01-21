<h2>View lifecycles <?php echo $model->idlifecycles; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('lifecycles List',array('list')); ?>]
[<?php echo CHtml::link('New lifecycles',array('create')); ?>]
[<?php echo CHtml::link('Update lifecycles',array('update','id'=>$model->idlifecycles)); ?>]
[<?php echo CHtml::linkButton('Delete lifecycles',array('submit'=>array('delete','id'=>$model->idlifecycles),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage lifecycles',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('lifecycle')); ?>
</th>
    <td><?php echo CHtml::encode($model->lifecycle); ?>
</td>
</tr>
</table>
