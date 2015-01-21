<h2>Managing collectedby</h2>

<div class="actionBar">
[<?php echo CHtml::link('collectedby List',array('list')); ?>]
[<?php echo CHtml::link('New collectedby',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idcollectedby'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idcollectedby,array('show','id'=>$model->idcollectedby)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idcollectedby)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idcollectedby),
      	  'confirm'=>"Are you sure to delete #{$model->idcollectedby}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>