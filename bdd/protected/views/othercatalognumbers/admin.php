<h2>Managing othercatalognumbers</h2>

<div class="actionBar">
[<?php echo CHtml::link('othercatalognumbers List',array('list')); ?>]
[<?php echo CHtml::link('New othercatalognumbers',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idothercatalognumbers'); ?></th>
    <th><?php echo $sort->link('othercatalognumbers'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idothercatalognumbers,array('show','id'=>$model->idothercatalognumbers)); ?></td>
    <td><?php echo CHtml::encode($model->othercatalognumbers); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idothercatalognumbers)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idothercatalognumbers),
      	  'confirm'=>"Are you sure to delete #{$model->idothercatalognumbers}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>