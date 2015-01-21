<h2>Update users <?php echo $users->idUser; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('users List',array('list')); ?>]
[<?php echo CHtml::link('New users',array('create')); ?>]
[<?php echo CHtml::link('Manage users',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'users'=>$users,
	'update'=>true,
)); ?>