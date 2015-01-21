<h2>View infraspecificranks <?php echo $infraspecificranks->idinfraspecificrank; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('infraspecificranks List',array('list')); ?>]
[<?php echo CHtml::link('New infraspecificranks',array('create')); ?>]
[<?php echo CHtml::link('Update infraspecificranks',array('update','id'=>$infraspecificranks->idinfraspecificrank)); ?>]
[<?php echo CHtml::linkButton('Delete infraspecificranks',array('submit'=>array('delete','id'=>$infraspecificranks->idinfraspecificrank),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage infraspecificranks',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($infraspecificranks->getAttributeLabel('infraspecificrank')); ?>
</th>
    <td><?php echo CHtml::encode($infraspecificranks->infraspecificrank); ?>
</td>
</tr>
</table>
