<h2>Update groups <?php echo $groups->idGroup; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('groups List',array('list')); ?>]
[<?php echo CHtml::link('New groups',array('create')); ?>]
[<?php echo CHtml::link('Manage groups',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'groups'=>$groups,
	'update'=>true,
)); ?>