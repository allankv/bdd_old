<h2>Update classes <?php echo $classes->idclass; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('classes List',array('list')); ?>]
[<?php echo CHtml::link('New classes',array('create')); ?>]
[<?php echo CHtml::link('Manage classes',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'classes'=>$classes,
	'update'=>true,
)); ?>