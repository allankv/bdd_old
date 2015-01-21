<h2>View dispersals <?php echo $model->iddispersal; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('dispersals List',array('list')); ?>]
[<?php echo CHtml::link('New dispersals',array('create')); ?>]
[<?php echo CHtml::link('Update dispersals',array('update','id'=>$model->iddispersal)); ?>]
[<?php echo CHtml::linkButton('Delete dispersals',array('submit'=>array('delete','id'=>$model->iddispersal),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage dispersals',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('dispersal')); ?>
</th>
    <td><?php echo CHtml::encode($model->dispersal); ?>
</td>
</tr>
</table>
