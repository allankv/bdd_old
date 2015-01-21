<h2>View ActiveRecordLog <?php echo $activerecordlog->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('ActiveRecordLog List',array('list')); ?>]
[<?php echo CHtml::link('New ActiveRecordLog',array('create')); ?>]
[<?php echo CHtml::link('Update ActiveRecordLog',array('update','id'=>$activerecordlog->id)); ?>]
[<?php echo CHtml::linkButton('Delete ActiveRecordLog',array('submit'=>array('delete','id'=>$activerecordlog->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage ActiveRecordLog',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($activerecordlog->getAttributeLabel('description')); ?>
</th>
    <td><?php echo CHtml::encode($activerecordlog->description); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($activerecordlog->getAttributeLabel('action')); ?>
</th>
    <td><?php echo CHtml::encode($activerecordlog->action); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($activerecordlog->getAttributeLabel('model')); ?>
</th>
    <td><?php echo CHtml::encode($activerecordlog->model); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($activerecordlog->getAttributeLabel('idModel')); ?>
</th>
    <td><?php echo CHtml::encode($activerecordlog->idModel); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($activerecordlog->getAttributeLabel('field')); ?>
</th>
    <td><?php echo CHtml::encode($activerecordlog->field); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($activerecordlog->getAttributeLabel('creationdate')); ?>
</th>
    <td><?php echo CHtml::encode($activerecordlog->creationdate); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($activerecordlog->getAttributeLabel('userid')); ?>
</th>
    <td><?php echo CHtml::encode($activerecordlog->userid); ?>
</td>
</tr>
</table>
