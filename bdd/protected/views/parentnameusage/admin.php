<h2>Managing parentnameusage</h2>

<div class="actionBar">
[<?php echo CHtml::link('parentnameusage List',array('list')); ?>]
[<?php echo CHtml::link('New parentnameusage',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idparentnameusage'); ?></th>
    <th><?php echo $sort->link('parentnameusage'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idparentnameusage,array('show','id'=>$model->idparentnameusage)); ?></td>
    <td><?php echo CHtml::encode($model->parentnameusage); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idparentnameusage)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idparentnameusage),
      	  'confirm'=>"Are you sure to delete #{$model->idparentnameusage}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>