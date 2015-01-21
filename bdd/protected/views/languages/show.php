<h2>View languages <?php echo $model->idlanguages; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('languages List',array('list')); ?>]
[<?php echo CHtml::link('New languages',array('create')); ?>]
[<?php echo CHtml::link('Update languages',array('update','id'=>$model->idlanguages)); ?>]
[<?php echo CHtml::linkButton('Delete languages',array('submit'=>array('delete','id'=>$model->idlanguages),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage languages',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('language')); ?>
</th>
    <td><?php echo CHtml::encode($model->language); ?>
</td>
</tr>
</table>
