<h2>Managing institutioncodes</h2>

<div class="actionBar">
[<?php echo CHtml::link('institutioncodes List',array('list')); ?>]
[<?php echo CHtml::link('New institutioncodes',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idinstitutioncode'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($institutioncodesList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idinstitutioncode,array('show','id'=>$model->idinstitutioncode)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idinstitutioncode)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idinstitutioncode),
      	  'confirm'=>"Are you sure to delete #{$model->idinstitutioncode}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>