<h2>Managing subgenus</h2>

<div class="actionBar">
[<?php echo CHtml::link('subgenus List',array('list')); ?>]
[<?php echo CHtml::link('New subgenus',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idsubgenus'); ?></th>
    <th><?php echo $sort->link('subgenus'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idsubgenus,array('show','id'=>$model->idsubgenus)); ?></td>
    <td><?php echo CHtml::encode($model->subgenus); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idsubgenus)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idsubgenus),
      	  'confirm'=>"Are you sure to delete #{$model->idsubgenus}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>