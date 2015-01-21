<h2>View phylums <?php echo $phylums->idphylum; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('phylums List',array('list')); ?>]
[<?php echo CHtml::link('New phylums',array('create')); ?>]
[<?php echo CHtml::link('Update phylums',array('update','id'=>$phylums->idphylum)); ?>]
[<?php echo CHtml::linkButton('Delete phylums',array('submit'=>array('delete','id'=>$phylums->idphylum),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage phylums',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($phylums->getAttributeLabel('phylum')); ?>
</th>
    <td><?php echo CHtml::encode($phylums->phylum); ?>
</td>
</tr>
</table>
