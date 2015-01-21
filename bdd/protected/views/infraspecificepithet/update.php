<h2>Update infraspecificepithets <?php echo $infraspecificepithets->idinfraspecificepithet; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('infraspecificepithets List',array('list')); ?>]
[<?php echo CHtml::link('New infraspecificepithets',array('create')); ?>]
[<?php echo CHtml::link('Manage infraspecificepithets',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'infraspecificepithets'=>$infraspecificepithets,
	'update'=>true,
)); ?>