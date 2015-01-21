<h2>View orders <?php echo $orders->idorder; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('orders List',array('list')); ?>]
[<?php echo CHtml::link('New orders',array('create')); ?>]
[<?php echo CHtml::link('Update orders',array('update','id'=>$orders->idorder)); ?>]
[<?php echo CHtml::linkButton('Delete orders',array('submit'=>array('delete','id'=>$orders->idorder),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage orders',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($orders->getAttributeLabel('order')); ?>
</th>
    <td><?php echo CHtml::encode($orders->order); ?>
</td>
</tr>
</table>
