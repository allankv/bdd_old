<h2>Managing annualcycle</h2>

<div class="actionBar">
[<?php echo CHtml::link('annualcycle List',array('list')); ?>]
[<?php echo CHtml::link('New annualcycle',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idannualcycle'); ?></th>
    <th><?php echo $sort->link('annualcycle'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idannualcycle,array('show','id'=>$model->idannualcycle)); ?></td>
    <td><?php echo CHtml::encode($model->annualcycle); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idannualcycle)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idannualcycle),
      	  'confirm'=>"Are you sure to delete #{$model->idannualcycle}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>