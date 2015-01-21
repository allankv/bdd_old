<h2>New users</h2>

<div class="actionBar">
[<?php echo CHtml::link('users List',array('list')); ?>]
[<?php echo CHtml::link('Manage users',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'users'=>$users,
	'update'=>false,
)); ?>