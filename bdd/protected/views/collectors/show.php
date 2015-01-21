<h2>View collectors <?php echo $collectors->idcollector; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('collectors List',array('list')); ?>]
[<?php echo CHtml::link('New collectors',array('create')); ?>]
[<?php echo CHtml::link('Update collectors',array('update','id'=>$collectors->idcollector)); ?>]
[<?php echo CHtml::linkButton('Delete collectors',array('submit'=>array('delete','id'=>$collectors->idcollector),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage collectors',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($collectors->getAttributeLabel('collector')); ?>
</th>
    <td><?php echo CHtml::encode($collectors->collector); ?>
</td>
</tr>
</table>
