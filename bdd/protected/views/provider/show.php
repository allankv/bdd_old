<h2>View provider <?php echo $provider->idprovider; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('provider List',array('list')); ?>]
[<?php echo CHtml::link('New provider',array('create')); ?>]
[<?php echo CHtml::link('Update provider',array('update','id'=>$provider->idprovider)); ?>]
[<?php echo CHtml::linkButton('Delete provider',array('submit'=>array('delete','id'=>$provider->idprovider),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage provider',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($provider->getAttributeLabel('provider')); ?>
</th>
    <td><?php echo CHtml::encode($provider->provider); ?>
</td>
</tr>
</table>
