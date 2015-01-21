<h2>Managing licenses</h2>

<div class="actionBar">
[<?php echo CHtml::link('licenses List',array('list')); ?>]
[<?php echo CHtml::link('New licenses',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idlicenses'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idlicenses,array('show','id'=>$model->idlicenses)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idlicenses)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idlicenses),
      	  'confirm'=>"Are you sure to delete #{$model->idlicenses}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>