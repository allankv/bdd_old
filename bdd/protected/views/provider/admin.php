<h2>Managing provider</h2>

<div class="actionBar">
[<?php echo CHtml::link('provider List',array('list')); ?>]
[<?php echo CHtml::link('New provider',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idprovider'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
<?php foreach($providerList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idprovider,array('show','id'=>$model->idprovider)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idprovider)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idprovider),
      	  'confirm'=>"Are you sure to delete #{$model->idprovider}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>