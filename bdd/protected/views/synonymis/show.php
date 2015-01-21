<h2>View synonymis <?php echo $model->idsynonyms; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('synonymis List',array('list')); ?>]
[<?php echo CHtml::link('New synonymis',array('create')); ?>]
[<?php echo CHtml::link('Update synonymis',array('update','id'=>$model->idsynonyms)); ?>]
[<?php echo CHtml::linkButton('Delete synonymis',array('submit'=>array('delete','id'=>$model->idsynonyms),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage synonymis',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('synonyms')); ?>
</th>
    <td><?php echo CHtml::encode($model->synonyms); ?>
</td>
</tr>
</table>
