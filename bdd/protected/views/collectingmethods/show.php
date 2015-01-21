<h2>View collectingmethods <?php echo $collectingmethods->idcollectingmethod; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('collectingmethods List',array('list')); ?>]
[<?php echo CHtml::link('New collectingmethods',array('create')); ?>]
[<?php echo CHtml::link('Update collectingmethods',array('update','id'=>$collectingmethods->idcollectingmethod)); ?>]
[<?php echo CHtml::linkButton('Delete collectingmethods',array('submit'=>array('delete','id'=>$collectingmethods->idcollectingmethod),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage collectingmethods',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($collectingmethods->getAttributeLabel('collectingmethod')); ?>
</th>
    <td><?php echo CHtml::encode($collectingmethods->collectingmethod); ?>
</td>
</tr>
</table>
