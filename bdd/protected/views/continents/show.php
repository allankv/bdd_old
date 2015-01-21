<h2>View continents <?php echo $continents->idcontinent; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('continents List',array('list')); ?>]
[<?php echo CHtml::link('New continents',array('create')); ?>]
[<?php echo CHtml::link('Update continents',array('update','id'=>$continents->idcontinent)); ?>]
[<?php echo CHtml::linkButton('Delete continents',array('submit'=>array('delete','id'=>$continents->idcontinent),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage continents',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($continents->getAttributeLabel('continent')); ?>
</th>
    <td><?php echo CHtml::encode($continents->continent); ?>
</td>
</tr>
</table>
