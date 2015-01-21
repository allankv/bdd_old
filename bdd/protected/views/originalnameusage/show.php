<h2>View originalnameusage <?php echo $model->idoriginalnameusage; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('originalnameusage List',array('list')); ?>]
[<?php echo CHtml::link('New originalnameusage',array('create')); ?>]
[<?php echo CHtml::link('Update originalnameusage',array('update','id'=>$model->idoriginalnameusage)); ?>]
[<?php echo CHtml::linkButton('Delete originalnameusage',array('submit'=>array('delete','id'=>$model->idoriginalnameusage),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage originalnameusage',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('originalnameusage')); ?>
</th>
    <td><?php echo CHtml::encode($model->originalnameusage); ?>
</td>
</tr>
</table>
