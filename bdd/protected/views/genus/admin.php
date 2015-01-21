<h2>Managing genus</h2>

<div class="actionBar">
[<?php echo CHtml::link('genus List',array('list')); ?>]
[<?php echo CHtml::link('New genus',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idgenus'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($genusList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idgenus,array('show','id'=>$model->idgenus)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idgenus)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idgenus),
      	  'confirm'=>"Are you sure to delete #{$model->idgenus}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>