<h2>Managing specificepithets</h2>

<div class="actionBar">
[<?php echo CHtml::link('specificepithets List',array('list')); ?>]
[<?php echo CHtml::link('New specificepithets',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idspecificepithet'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($specificepithetsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idspecificepithet,array('show','id'=>$model->idspecificepithet)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idspecificepithet)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idspecificepithet),
      	  'confirm'=>"Are you sure to delete #{$model->idspecificepithet}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>