<h2>Managing instructionalmethods</h2>

<div class="actionBar">
[<?php echo CHtml::link('instructionalmethods List',array('list')); ?>]
[<?php echo CHtml::link('New instructionalmethods',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idinstructionalmethods'); ?></th>
    <th><?php echo $sort->link('instrumentalmethod'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idinstructionalmethods,array('show','id'=>$model->idinstructionalmethods)); ?></td>
    <td><?php echo CHtml::encode($model->instrumentalmethod); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idinstructionalmethods)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idinstructionalmethods),
      	  'confirm'=>"Are you sure to delete #{$model->idinstructionalmethods}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>