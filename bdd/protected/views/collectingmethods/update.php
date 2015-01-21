<h2>Update collectingmethods <?php echo $collectingmethods->idcollectingmethod; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('collectingmethods List',array('list')); ?>]
[<?php echo CHtml::link('New collectingmethods',array('create')); ?>]
[<?php echo CHtml::link('Manage collectingmethods',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'collectingmethods'=>$collectingmethods,
	'update'=>true,
)); ?>