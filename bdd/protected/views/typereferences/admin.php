<h2>Managing typereferences</h2>

<div class="actionBar">
[<?php echo CHtml::link('typereferences List',array('list')); ?>]
[<?php echo CHtml::link('New typereferences',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idtypereferences'); ?></th>
    <th><?php echo $sort->link('typereferences'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idtypereferences,array('show','id'=>$model->idtypereferences)); ?></td>
    <td><?php echo CHtml::encode($model->typereferences); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idtypereferences)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idtypereferences),
      	  'confirm'=>"Are you sure to delete #{$model->idtypereferences}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>