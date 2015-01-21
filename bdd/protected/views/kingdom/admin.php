<h2>Managing kingdoms</h2>

<div class="actionBar">
[<?php echo CHtml::link('kingdoms List',array('list')); ?>]
[<?php echo CHtml::link('New kingdoms',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idkingdom'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($kingdomsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idkingdom,array('show','id'=>$model->idkingdom)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idkingdom)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idkingdom),
      	  'confirm'=>"Are you sure to delete #{$model->idkingdom}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>