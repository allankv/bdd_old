<h2>View georeferedby <?php echo $model->idgeoreferdby; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('georeferedby List',array('list')); ?>]
[<?php echo CHtml::link('New georeferedby',array('create')); ?>]
[<?php echo CHtml::link('Update georeferedby',array('update','id'=>$model->idgeoreferdby)); ?>]
[<?php echo CHtml::linkButton('Delete georeferedby',array('submit'=>array('delete','id'=>$model->idgeoreferdby),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage georeferedby',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('georeferdedby')); ?>
</th>
    <td><?php echo CHtml::encode($model->georeferdedby); ?>
</td>
</tr>
</table>
