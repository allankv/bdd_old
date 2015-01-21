<h2>Update provider <?php echo $provider->idprovider; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('provider List',array('list')); ?>]
[<?php echo CHtml::link('New provider',array('create')); ?>]
[<?php echo CHtml::link('Manage provider',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'provider'=>$provider,
	'update'=>true,
)); ?>