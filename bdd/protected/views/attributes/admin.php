<h2>Managing attributes</h2>

<div class="actionBar">
[<?php echo CHtml::link('attributes List',array('list')); ?>]
[<?php echo CHtml::link('New attributes',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idAttribute'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($attributesList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idAttribute,array('show','id'=>$model->idAttribute)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idAttribute)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idAttribute),
      	  'confirm'=>"Are you sure to delete #{$model->idAttribute}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>