<h2>Managing infraspecificepithets</h2>

<div class="actionBar">
[<?php echo CHtml::link('infraspecificepithets List',array('list')); ?>]
[<?php echo CHtml::link('New infraspecificepithets',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idinfraspecificepithet'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($infraspecificepithetsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idinfraspecificepithet,array('show','id'=>$model->idinfraspecificepithet)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idinfraspecificepithet)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idinfraspecificepithet),
      	  'confirm'=>"Are you sure to delete #{$model->idinfraspecificepithet}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>