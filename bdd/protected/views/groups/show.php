<h2>View groups <?php echo $groups->idGroup; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('groups List',array('list')); ?>]
[<?php echo CHtml::link('New groups',array('create')); ?>]
[<?php echo CHtml::link('Update groups',array('update','id'=>$groups->idGroup)); ?>]
[<?php echo CHtml::linkButton('Delete groups',array('submit'=>array('delete','id'=>$groups->idGroup),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage groups',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($groups->getAttributeLabel('group')); ?>
</th>
    <td><?php echo CHtml::encode($groups->group); ?>
</td>
</tr>
</table>
