<h2>View licenses <?php echo $model->idlicenses; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('licenses List',array('list')); ?>]
[<?php echo CHtml::link('New licenses',array('create')); ?>]
[<?php echo CHtml::link('Update licenses',array('update','id'=>$model->idlicenses)); ?>]
[<?php echo CHtml::linkButton('Delete licenses',array('submit'=>array('delete','id'=>$model->idlicenses),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage licenses',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('licenses')); ?>
</th>
    <td><?php echo CHtml::encode($model->licenses); ?>
</td>
</tr>
</table>
