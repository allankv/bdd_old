<h2>View biologicalelements <?php echo $biologicalelements->idbiologicalelements; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('biologicalelements List',array('list')); ?>]
[<?php echo CHtml::link('New biologicalelements',array('create')); ?>]
[<?php echo CHtml::link('Update biologicalelements',array('update','id'=>$biologicalelements->idbiologicalelements)); ?>]
[<?php echo CHtml::linkButton('Delete biologicalelements',array('submit'=>array('delete','id'=>$biologicalelements->idbiologicalelements),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage biologicalelements',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($biologicalelements->getAttributeLabel('idsex')); ?>
</th>
    <td><?php echo CHtml::encode($biologicalelements->idsex); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($biologicalelements->getAttributeLabel('idlifestage')); ?>
</th>
    <td><?php echo CHtml::encode($biologicalelements->idlifestage); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($biologicalelements->getAttributeLabel('attribute')); ?>
</th>
    <td><?php echo CHtml::encode($biologicalelements->attribute); ?>
</td>
</tr>
</table>
