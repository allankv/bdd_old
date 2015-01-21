<h2>Update scientificnames <?php echo $scientificnames->idscientificname; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('scientificnames List',array('list')); ?>]
[<?php echo CHtml::link('New scientificnames',array('create')); ?>]
[<?php echo CHtml::link('Manage scientificnames',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'scientificnames'=>$scientificnames,
	'update'=>true,
)); ?>