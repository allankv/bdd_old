<h2>View families <?php echo $families->idfamily; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('families List',array('list')); ?>]
[<?php echo CHtml::link('New families',array('create')); ?>]
[<?php echo CHtml::link('Update families',array('update','id'=>$families->idfamily)); ?>]
[<?php echo CHtml::linkButton('Delete families',array('submit'=>array('delete','id'=>$families->idfamily),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage families',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($families->getAttributeLabel('family')); ?>
</th>
    <td><?php echo CHtml::encode($families->family); ?>
</td>
</tr>
</table>
