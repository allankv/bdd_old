<h2>Managing collectors</h2>

<div class="actionBar">
[<?php echo CHtml::link('collectors List',array('list')); ?>]
[<?php echo CHtml::link('New collectors',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idcollector'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($collectorsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idcollector,array('show','id'=>$model->idcollector)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idcollector)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idcollector),
      	  'confirm'=>"Are you sure to delete #{$model->idcollector}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>