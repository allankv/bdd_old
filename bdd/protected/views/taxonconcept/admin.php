<h2>Managing taxonconcept</h2>

<div class="actionBar">
[<?php echo CHtml::link('taxonconcept List',array('list')); ?>]
[<?php echo CHtml::link('New taxonconcept',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idtaxonconcept'); ?></th>
    <th><?php echo $sort->link('taxonconcept'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idtaxonconcept,array('show','id'=>$model->idtaxonconcept)); ?></td>
    <td><?php echo CHtml::encode($model->taxonconcept); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idtaxonconcept)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idtaxonconcept),
      	  'confirm'=>"Are you sure to delete #{$model->idtaxonconcept}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>