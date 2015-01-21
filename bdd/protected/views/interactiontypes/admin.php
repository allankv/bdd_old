<h2>Managing interactiontypes</h2>

<div class="actionBar">
[<?php echo CHtml::link('interactiontypes List',array('list')); ?>]
[<?php echo CHtml::link('New interactiontypes',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idinteractiontype'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($interactiontypesList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idinteractiontype,array('show','id'=>$model->idinteractiontype)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idinteractiontype)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idinteractiontype),
      	  'confirm'=>"Are you sure to delete #{$model->idinteractiontype}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>