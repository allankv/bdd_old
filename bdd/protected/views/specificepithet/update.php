<h2>Update specificepithets <?php echo $specificepithets->idspecificepithet; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('specificepithets List',array('list')); ?>]
[<?php echo CHtml::link('New specificepithets',array('create')); ?>]
[<?php echo CHtml::link('Manage specificepithets',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'specificepithets'=>$specificepithets,
	'update'=>true,
)); ?>