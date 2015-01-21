<h2>Managing occurrenceelements</h2>

<div class="actionBar">
[<?php echo CHtml::link('occurrenceelements List',array('list')); ?>]
[<?php echo CHtml::link('New occurrenceelements',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idoccurrenceelements'); ?></th>
    <th><?php echo $sort->link('catalognumber'); ?></th>
    <th><?php echo $sort->link('recordnumber'); ?></th>
    <th><?php echo $sort->link('individualcount'); ?></th>
    <th><?php echo $sort->link('occurrencestatus'); ?></th>
    <th><?php echo $sort->link('iddisposition'); ?></th>
    <th><?php echo $sort->link('idestablishmentmeans'); ?></th>
    <th><?php echo $sort->link('idbehavior'); ?></th>
    <th><?php echo $sort->link('idreproductivecondition'); ?></th>
    <th><?php echo $sort->link('idlifestage'); ?></th>
    <th><?php echo $sort->link('idsex'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idoccurrenceelements,array('show','id'=>$model->idoccurrenceelements)); ?></td>
    <td><?php echo CHtml::encode($model->catalognumber); ?></td>
    <td><?php echo CHtml::encode($model->recordnumber); ?></td>
    <td><?php echo CHtml::encode($model->individualcount); ?></td>
    <td><?php echo CHtml::encode($model->occurrencestatus); ?></td>
    <td><?php echo CHtml::encode($model->iddisposition); ?></td>
    <td><?php echo CHtml::encode($model->idestablishmentmeans); ?></td>
    <td><?php echo CHtml::encode($model->idbehavior); ?></td>
    <td><?php echo CHtml::encode($model->idreproductivecondition); ?></td>
    <td><?php echo CHtml::encode($model->idlifestage); ?></td>
    <td><?php echo CHtml::encode($model->idsex); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idoccurrenceelements)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idoccurrenceelements),
      	  'confirm'=>"Are you sure to delete #{$model->idoccurrenceelements}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>