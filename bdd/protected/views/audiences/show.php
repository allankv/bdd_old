<h2>View audiences <?php echo $model->idaudiences; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('audiences List',array('list')); ?>]
[<?php echo CHtml::link('New audiences',array('create')); ?>]
[<?php echo CHtml::link('Update audiences',array('update','id'=>$model->idaudiences)); ?>]
[<?php echo CHtml::linkButton('Delete audiences',array('submit'=>array('delete','id'=>$model->idaudiences),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage audiences',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('audience')); ?>
</th>
    <td><?php echo CHtml::encode($model->audience); ?>
</td>
</tr>
</table>
