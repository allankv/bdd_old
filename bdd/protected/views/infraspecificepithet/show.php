<h2>View infraspecificepithets <?php echo $infraspecificepithets->idinfraspecificepithet; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('infraspecificepithets List',array('list')); ?>]
[<?php echo CHtml::link('New infraspecificepithets',array('create')); ?>]
[<?php echo CHtml::link('Update infraspecificepithets',array('update','id'=>$infraspecificepithets->idinfraspecificepithet)); ?>]
[<?php echo CHtml::linkButton('Delete infraspecificepithets',array('submit'=>array('delete','id'=>$infraspecificepithets->idinfraspecificepithet),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage infraspecificepithets',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($infraspecificepithets->getAttributeLabel('infraspecificepithet')); ?>
</th>
    <td><?php echo CHtml::encode($infraspecificepithets->infraspecificepithet); ?>
</td>
</tr>
</table>
