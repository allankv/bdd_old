<h2>audiences List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New audiences',array('create')); ?>]
[<?php echo CHtml::link('Manage audiences',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idaudiences')); ?>:
<?php echo CHtml::link($model->idaudiences,array('show','id'=>$model->idaudiences)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('audience')); ?>:
<?php echo CHtml::encode($model->audience); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>