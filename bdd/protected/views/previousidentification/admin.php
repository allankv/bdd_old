<h2>Managing previousidentification</h2>

<div class="actionBar">
[<?php echo CHtml::link('previousidentification List',array('list')); ?>]
[<?php echo CHtml::link('New previousidentification',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idpreviousidentification'); ?></th>
    <th><?php echo $sort->link('idrecordlevelelements'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idpreviousidentification,array('show','id'=>$model->idpreviousidentification)); ?></td>
    <td><?php echo CHtml::encode($model->idrecordlevelelements); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idpreviousidentification)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idpreviousidentification),
      	  'confirm'=>"Are you sure to delete #{$model->idpreviousidentification}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>