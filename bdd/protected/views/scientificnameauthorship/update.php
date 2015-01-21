<h2>Update scientificnameauthorships <?php echo $scientificnameauthorships->idscientificnameauthorship; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('scientificnameauthorships List',array('list')); ?>]
[<?php echo CHtml::link('New scientificnameauthorships',array('create')); ?>]
[<?php echo CHtml::link('Manage scientificnameauthorships',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'scientificnameauthorships'=>$scientificnameauthorships,
	'update'=>true,
)); ?>