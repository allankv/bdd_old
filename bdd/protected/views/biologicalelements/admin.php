<h2>Managing biologicalelements</h2>

<div class="actionBar">
[<?php echo CHtml::link('biologicalelements List',array('list')); ?>]
[<?php echo CHtml::link('New biologicalelements',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idbiologicalelements'); ?></th>
    <th><?php echo $sort->link('idsex'); ?></th>
    <th><?php echo $sort->link('idlifestage'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($biologicalelementsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idbiologicalelements,array('show','id'=>$model->idbiologicalelements)); ?></td>
    <td><?php echo CHtml::encode($model->idsex); ?></td>
    <td><?php echo CHtml::encode($model->idlifestage); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idbiologicalelements)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idbiologicalelements),
      	  'confirm'=>"Are you sure to delete #{$model->idbiologicalelements}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>