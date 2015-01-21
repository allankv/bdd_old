<h2>View kingdoms <?php echo $kingdoms->idkingdom; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('kingdoms List',array('list')); ?>]
[<?php echo CHtml::link('New kingdoms',array('create')); ?>]
[<?php echo CHtml::link('Update kingdoms',array('update','id'=>$kingdoms->idkingdom)); ?>]
[<?php echo CHtml::linkButton('Delete kingdoms',array('submit'=>array('delete','id'=>$kingdoms->idkingdom),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage kingdoms',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($kingdoms->getAttributeLabel('kingdom')); ?>
</th>
    <td><?php echo CHtml::encode($kingdoms->kingdom); ?>
</td>
</tr>
</table>
