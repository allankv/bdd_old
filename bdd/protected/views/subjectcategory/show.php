<h2>View subjectcategory <?php echo $model->idsubjectcategory; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('subjectcategory List',array('list')); ?>]
[<?php echo CHtml::link('New subjectcategory',array('create')); ?>]
[<?php echo CHtml::link('Update subjectcategory',array('update','id'=>$model->idsubjectcategory)); ?>]
[<?php echo CHtml::linkButton('Delete subjectcategory',array('submit'=>array('delete','id'=>$model->idsubjectcategory),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage subjectcategory',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('subjectcategory')); ?>
</th>
    <td><?php echo CHtml::encode($model->subjectcategory); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('idsubjectcategoryvocabulary')); ?>
</th>
    <td><?php echo CHtml::encode($model->idsubjectcategoryvocabulary); ?>
</td>
</tr>
</table>
