<h2>New associatedmedia</h2>

<div class="actionBar">
[<?php echo CHtml::link('associatedmedia List',array('list')); ?>]
[<?php echo CHtml::link('Manage associatedmedia',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>