<h2>Update kingdoms <?php echo $kingdoms->idkingdom; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('kingdoms List',array('list')); ?>]
[<?php echo CHtml::link('New kingdoms',array('create')); ?>]
[<?php echo CHtml::link('Manage kingdoms',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'kingdoms'=>$kingdoms,
	'update'=>true,
)); ?>