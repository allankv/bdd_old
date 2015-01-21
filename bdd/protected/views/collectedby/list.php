<h2>collectedby List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New collectedby',array('create')); ?>]
[<?php echo CHtml::link('Manage collectedby',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idcollectedby')); ?>:
<?php echo CHtml::link($model->idcollectedby,array('show','id'=>$model->idcollectedby)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('collectedby')); ?>:
<?php echo CHtml::encode($model->collectedby); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>