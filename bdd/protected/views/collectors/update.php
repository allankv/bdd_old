<h2>Update collectors <?php echo $collectors->idcollector; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('collectors List',array('list')); ?>]
[<?php echo CHtml::link('New collectors',array('create')); ?>]
[<?php echo CHtml::link('Manage collectors',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'collectors'=>$collectors,
	'update'=>true,
)); ?>