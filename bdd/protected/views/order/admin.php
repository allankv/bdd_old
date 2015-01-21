<h2>Managing orders</h2>

<div class="actionBar">
[<?php echo CHtml::link('orders List',array('list')); ?>]
[<?php echo CHtml::link('New orders',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idorder'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($ordersList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idorder,array('show','id'=>$model->idorder)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idorder)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idorder),
      	  'confirm'=>"Are you sure to delete #{$model->idorder}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>