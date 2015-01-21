<h2>View fileformats <?php echo $model->idfileformats; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('fileformats List',array('list')); ?>]
[<?php echo CHtml::link('New fileformats',array('create')); ?>]
[<?php echo CHtml::link('Update fileformats',array('update','id'=>$model->idfileformats)); ?>]
[<?php echo CHtml::linkButton('Delete fileformats',array('submit'=>array('delete','id'=>$model->idfileformats),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage fileformats',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('fileformat')); ?>
</th>
    <td><?php echo CHtml::encode($model->fileformat); ?>
</td>
</tr>
</table>
