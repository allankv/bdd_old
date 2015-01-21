<h2>Update genus <?php echo $genus->idgenus; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('genus List',array('list')); ?>]
[<?php echo CHtml::link('New genus',array('create')); ?>]
[<?php echo CHtml::link('Manage genus',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'genus'=>$genus,
	'update'=>true,
)); ?>