<h2>Update taxonrank <?php echo $taxonranks->idinfraspecificrank; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('taxonrank List',array('list')); ?>]
[<?php echo CHtml::link('New taxonrank',array('create')); ?>]
[<?php echo CHtml::link('Manage taxonrank',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'taxonranks'=>$taxonranks,
	'update'=>true,
)); ?>