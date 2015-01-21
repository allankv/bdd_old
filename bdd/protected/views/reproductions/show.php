<h2>View reproductions <?php echo $model->idreproduction; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('reproductions List',array('list')); ?>]
[<?php echo CHtml::link('New reproductions',array('create')); ?>]
[<?php echo CHtml::link('Update reproductions',array('update','id'=>$model->idreproduction)); ?>]
[<?php echo CHtml::linkButton('Delete reproductions',array('submit'=>array('delete','id'=>$model->idreproduction),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage reproductions',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('reproductions')); ?>
</th>
    <td><?php echo CHtml::encode($model->reproductions); ?>
</td>
</tr>
</table>
