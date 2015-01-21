<h2>Managing nameaccordingto</h2>

<div class="actionBar">
[<?php echo CHtml::link('nameaccordingto List',array('list')); ?>]
[<?php echo CHtml::link('New nameaccordingto',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idnameaccordingto'); ?></th>
    <th><?php echo $sort->link('nameaccordingto'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idnameaccordingto,array('show','id'=>$model->idnameaccordingto)); ?></td>
    <td><?php echo CHtml::encode($model->nameaccordingto); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idnameaccordingto)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idnameaccordingto),
      	  'confirm'=>"Are you sure to delete #{$model->idnameaccordingto}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>