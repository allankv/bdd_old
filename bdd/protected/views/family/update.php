<h2>Update families <?php echo $families->idfamily; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('families List',array('list')); ?>]
[<?php echo CHtml::link('New families',array('create')); ?>]
[<?php echo CHtml::link('Manage families',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'families'=>$families,
	'update'=>true,
)); ?>