<h2>Managing originalnameusage</h2>

<div class="actionBar">
[<?php echo CHtml::link('originalnameusage List',array('list')); ?>]
[<?php echo CHtml::link('New originalnameusage',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idoriginalnameusage'); ?></th>
    <th><?php echo $sort->link('originalnameusage'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idoriginalnameusage,array('show','id'=>$model->idoriginalnameusage)); ?></td>
    <td><?php echo CHtml::encode($model->originalnameusage); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idoriginalnameusage)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idoriginalnameusage),
      	  'confirm'=>"Are you sure to delete #{$model->idoriginalnameusage}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>