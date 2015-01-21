<h2>Managing classes</h2>

<div class="actionBar">
[<?php echo CHtml::link('classes List',array('list')); ?>]
[<?php echo CHtml::link('New classes',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idclass'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($classesList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idclass,array('show','id'=>$model->idclass)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idclass)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idclass),
      	  'confirm'=>"Are you sure to delete #{$model->idclass}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>