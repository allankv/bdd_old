<h2>View validdistributionflags <?php echo $validdistributionflags->idvaliddistributionflag; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('validdistributionflags List',array('list')); ?>]
[<?php echo CHtml::link('New validdistributionflags',array('create')); ?>]
[<?php echo CHtml::link('Update validdistributionflags',array('update','id'=>$validdistributionflags->idvaliddistributionflag)); ?>]
[<?php echo CHtml::linkButton('Delete validdistributionflags',array('submit'=>array('delete','id'=>$validdistributionflags->idvaliddistributionflag),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage validdistributionflags',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($validdistributionflags->getAttributeLabel('validdistributionflag')); ?>
</th>
    <td><?php echo CHtml::encode($validdistributionflags->validdistributionflag); ?>
</td>
</tr>
</table>
