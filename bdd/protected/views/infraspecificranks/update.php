<h2>Update infraspecificranks <?php echo $infraspecificranks->idinfraspecificrank; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('infraspecificranks List',array('list')); ?>]
[<?php echo CHtml::link('New infraspecificranks',array('create')); ?>]
[<?php echo CHtml::link('Manage infraspecificranks',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'infraspecificranks'=>$infraspecificranks,
	'update'=>true,
)); ?>