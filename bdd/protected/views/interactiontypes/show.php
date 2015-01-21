<h2>View interactiontypes <?php echo $interactiontypes->idinteractiontype; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('interactiontypes List',array('list')); ?>]
[<?php echo CHtml::link('New interactiontypes',array('create')); ?>]
[<?php echo CHtml::link('Update interactiontypes',array('update','id'=>$interactiontypes->idinteractiontype)); ?>]
[<?php echo CHtml::linkButton('Delete interactiontypes',array('submit'=>array('delete','id'=>$interactiontypes->idinteractiontype),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage interactiontypes',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($interactiontypes->getAttributeLabel('interactiontype')); ?>
</th>
    <td><?php echo CHtml::encode($interactiontypes->interactiontype); ?>
</td>
</tr>
</table>
