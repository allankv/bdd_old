<h2>View collectingeventelements <?php echo $collectingeventelements->idcollectingeventelements; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('collectingeventelements List',array('list')); ?>]
[<?php echo CHtml::link('New collectingeventelements',array('create')); ?>]
[<?php echo CHtml::link('Update collectingeventelements',array('update','id'=>$collectingeventelements->idcollectingeventelements)); ?>]
[<?php echo CHtml::linkButton('Delete collectingeventelements',array('submit'=>array('delete','id'=>$collectingeventelements->idcollectingeventelements),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage collectingeventelements',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($collectingeventelements->getAttributeLabel('idcollectingmethod')); ?>
</th>
    <td><?php echo CHtml::encode($collectingeventelements->idcollectingmethod); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($collectingeventelements->getAttributeLabel('idvaliddistributionflag')); ?>
</th>
    <td><?php echo CHtml::encode($collectingeventelements->idvaliddistributionflag); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($collectingeventelements->getAttributeLabel('earliestdatecollected')); ?>
</th>
    <td><?php echo CHtml::encode($collectingeventelements->earliestdatecollected); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($collectingeventelements->getAttributeLabel('latestdatecollected')); ?>
</th>
    <td><?php echo CHtml::encode($collectingeventelements->latestdatecollected); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($collectingeventelements->getAttributeLabel('dayofyear')); ?>
</th>
    <td><?php echo CHtml::encode($collectingeventelements->dayofyear); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($collectingeventelements->getAttributeLabel('idcollector')); ?>
</th>
    <td><?php echo CHtml::encode($collectingeventelements->idcollector); ?>
</td>
</tr>
</table>
