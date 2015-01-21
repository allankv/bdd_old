<h2>Managing taxonrank</h2>

<div class="actionBar">
[<?php echo CHtml::link('taxonranks List',array('list')); ?>]
[<?php echo CHtml::link('New taxonranks',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idinfraspecificrank'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($taxonranksList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idinfraspecificrank,array('show','id'=>$model->idinfraspecificrank)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idinfraspecificrank)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idinfraspecificrank),
      	  'confirm'=>"Are you sure to delete #{$model->idinfraspecificrank}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>