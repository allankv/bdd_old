<h2>View taxonconcept <?php echo $model->idtaxonconcept; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('taxonconcept List',array('list')); ?>]
[<?php echo CHtml::link('New taxonconcept',array('create')); ?>]
[<?php echo CHtml::link('Update taxonconcept',array('update','id'=>$model->idtaxonconcept)); ?>]
[<?php echo CHtml::linkButton('Delete taxonconcept',array('submit'=>array('delete','id'=>$model->idtaxonconcept),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage taxonconcept',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('taxonconcept')); ?>
</th>
    <td><?php echo CHtml::encode($model->taxonconcept); ?>
</td>
</tr>
</table>
