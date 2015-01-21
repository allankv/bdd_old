<h2>migrations List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New migrations',array('create')); ?>]
[<?php echo CHtml::link('Manage migrations',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idmigration')); ?>:
<?php echo CHtml::link($model->idmigration,array('show','id'=>$model->idmigration)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('migration')); ?>:
<?php echo CHtml::encode($model->migration); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>