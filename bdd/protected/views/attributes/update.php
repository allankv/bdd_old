<h2>Update attributes <?php echo $attributes->idAttribute; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('attributes List',array('list')); ?>]
[<?php echo CHtml::link('New attributes',array('create')); ?>]
[<?php echo CHtml::link('Manage attributes',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'attributes'=>$attributes,
	'update'=>true,
)); ?>