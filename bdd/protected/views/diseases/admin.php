<h2>Managing diseases</h2>

<div class="actionBar">
[<?php echo CHtml::link('diseases List',array('list')); ?>]
[<?php echo CHtml::link('New diseases',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('iddiseases'); ?></th>
    <th><?php echo $sort->link('deseases'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->iddiseases,array('show','id'=>$model->iddiseases)); ?></td>
    <td><?php echo CHtml::encode($model->deseases); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->iddiseases)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->iddiseases),
      	  'confirm'=>"Are you sure to delete #{$model->iddiseases}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>