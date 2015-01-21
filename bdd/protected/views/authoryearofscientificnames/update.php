<h2>Update authoryearofscientificnames <?php echo $authoryearofscientificnames->idauthoryearofscientificname; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('authoryearofscientificnames List',array('list')); ?>]
[<?php echo CHtml::link('New authoryearofscientificnames',array('create')); ?>]
[<?php echo CHtml::link('Manage authoryearofscientificnames',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'authoryearofscientificnames'=>$authoryearofscientificnames,
	'update'=>true,
)); ?>