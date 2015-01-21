<h2>Managing collectingmethods</h2>

<div class="actionBar">
[<?php echo CHtml::link('collectingmethods List',array('list')); ?>]
[<?php echo CHtml::link('New collectingmethods',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idcollectingmethod'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($collectingmethodsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idcollectingmethod,array('show','id'=>$model->idcollectingmethod)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idcollectingmethod)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idcollectingmethod),
      	  'confirm'=>"Are you sure to delete #{$model->idcollectingmethod}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>