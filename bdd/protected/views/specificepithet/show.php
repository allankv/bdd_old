<h2>View specificepithets <?php echo $specificepithets->idspecificepithet; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('specificepithets List',array('list')); ?>]
[<?php echo CHtml::link('New specificepithets',array('create')); ?>]
[<?php echo CHtml::link('Update specificepithets',array('update','id'=>$specificepithets->idspecificepithet)); ?>]
[<?php echo CHtml::linkButton('Delete specificepithets',array('submit'=>array('delete','id'=>$specificepithets->idspecificepithet),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage specificepithets',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($specificepithets->getAttributeLabel('specificepithet')); ?>
</th>
    <td><?php echo CHtml::encode($specificepithets->specificepithet); ?>
</td>
</tr>
</table>
