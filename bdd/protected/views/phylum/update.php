<h2>Update phylums <?php echo $phylums->idphylum; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('phylums List',array('list')); ?>]
[<?php echo CHtml::link('New phylums',array('create')); ?>]
[<?php echo CHtml::link('Manage phylums',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'phylums'=>$phylums,
	'update'=>true,
)); ?>