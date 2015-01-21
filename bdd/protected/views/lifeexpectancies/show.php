<h2>View lifeexpectancies <?php echo $model->idlifeexpectancies; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('lifeexpectancies List',array('list')); ?>]
[<?php echo CHtml::link('New lifeexpectancies',array('create')); ?>]
[<?php echo CHtml::link('Update lifeexpectancies',array('update','id'=>$model->idlifeexpectancies)); ?>]
[<?php echo CHtml::linkButton('Delete lifeexpectancies',array('submit'=>array('delete','id'=>$model->idlifeexpectancies),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage lifeexpectancies',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('lifeexpectancies')); ?>
</th>
    <td><?php echo CHtml::encode($model->lifeexpectancies); ?>
</td>
</tr>
</table>
