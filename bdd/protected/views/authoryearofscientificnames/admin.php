<h2>Managing authoryearofscientificnames</h2>

<div class="actionBar">
[<?php echo CHtml::link('authoryearofscientificnames List',array('list')); ?>]
[<?php echo CHtml::link('New authoryearofscientificnames',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idauthoryearofscientificname'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($authoryearofscientificnamesList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idauthoryearofscientificname,array('show','id'=>$model->idauthoryearofscientificname)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idauthoryearofscientificname)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idauthoryearofscientificname),
      	  'confirm'=>"Are you sure to delete #{$model->idauthoryearofscientificname}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>