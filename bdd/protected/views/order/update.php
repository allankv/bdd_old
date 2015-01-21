<h2>Update orders <?php echo $orders->idorder; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('orders List',array('list')); ?>]
[<?php echo CHtml::link('New orders',array('create')); ?>]
[<?php echo CHtml::link('Manage orders',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'orders'=>$orders,
	'update'=>true,
)); ?>