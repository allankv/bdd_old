<h2>View taxonomicstatus <?php echo $model->idtaxonomicstatus; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('taxonomicstatus List',array('list')); ?>]
[<?php echo CHtml::link('New taxonomicstatus',array('create')); ?>]
[<?php echo CHtml::link('Update taxonomicstatus',array('update','id'=>$model->idtaxonomicstatus)); ?>]
[<?php echo CHtml::linkButton('Delete taxonomicstatus',array('submit'=>array('delete','id'=>$model->idtaxonomicstatus),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage taxonomicstatus',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('taxonomicstatus')); ?>
</th>
    <td><?php echo CHtml::encode($model->taxonomicstatus); ?>
</td>
</tr>
</table>
