<h2>View canonicalauthorship <?php echo $model->idcanonicalauthorship; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('canonicalauthorship List',array('list')); ?>]
[<?php echo CHtml::link('New canonicalauthorship',array('create')); ?>]
[<?php echo CHtml::link('Update canonicalauthorship',array('update','id'=>$model->idcanonicalauthorship)); ?>]
[<?php echo CHtml::linkButton('Delete canonicalauthorship',array('submit'=>array('delete','id'=>$model->idcanonicalauthorship),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage canonicalauthorship',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('canonicalauthorship')); ?>
</th>
    <td><?php echo CHtml::encode($model->canonicalauthorship); ?>
</td>
</tr>
</table>
