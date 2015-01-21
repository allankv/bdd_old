<h2>View attributes <?php echo $attributes->idAttribute; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('attributes List',array('list')); ?>]
[<?php echo CHtml::link('New attributes',array('create')); ?>]
[<?php echo CHtml::link('Update attributes',array('update','id'=>$attributes->idAttribute)); ?>]
[<?php echo CHtml::linkButton('Delete attributes',array('submit'=>array('delete','id'=>$attributes->idAttribute),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage attributes',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($attributes->getAttributeLabel('attribute')); ?>
</th>
    <td><?php echo CHtml::encode($attributes->attribute); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($attributes->getAttributeLabel('description')); ?>
</th>
    <td><?php echo CHtml::encode($attributes->description); ?>
</td>
</tr>
</table>
