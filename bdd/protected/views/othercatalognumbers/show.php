<h2>View othercatalognumbers <?php echo $model->idothercatalognumbers; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('othercatalognumbers List',array('list')); ?>]
[<?php echo CHtml::link('New othercatalognumbers',array('create')); ?>]
[<?php echo CHtml::link('Update othercatalognumbers',array('update','id'=>$model->idothercatalognumbers)); ?>]
[<?php echo CHtml::linkButton('Delete othercatalognumbers',array('submit'=>array('delete','id'=>$model->idothercatalognumbers),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage othercatalognumbers',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('othercatalognumbers')); ?>
</th>
    <td><?php echo CHtml::encode($model->othercatalognumbers); ?>
</td>
</tr>
</table>
