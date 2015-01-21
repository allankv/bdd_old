<h2>View nameaccordingto <?php echo $model->idnameaccordingto; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('nameaccordingto List',array('list')); ?>]
[<?php echo CHtml::link('New nameaccordingto',array('create')); ?>]
[<?php echo CHtml::link('Update nameaccordingto',array('update','id'=>$model->idnameaccordingto)); ?>]
[<?php echo CHtml::linkButton('Delete nameaccordingto',array('submit'=>array('delete','id'=>$model->idnameaccordingto),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage nameaccordingto',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('nameaccordingto')); ?>
</th>
    <td><?php echo CHtml::encode($model->nameaccordingto); ?>
</td>
</tr>
</table>
