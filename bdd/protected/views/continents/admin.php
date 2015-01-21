<h2>Managing continents</h2>

<div class="actionBar">
[<?php echo CHtml::link('continents List',array('list')); ?>]
[<?php echo CHtml::link('New continents',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idcontinent'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($continentsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idcontinent,array('show','id'=>$model->idcontinent)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idcontinent)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idcontinent),
      	  'confirm'=>"Are you sure to delete #{$model->idcontinent}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>