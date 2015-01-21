<h2>interactiontypes List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New interactiontypes',array('create')); ?>]
[<?php echo CHtml::link('Manage interactiontypes',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($interactiontypesList as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idinteractiontype')); ?>:
<?php echo CHtml::link($model->idinteractiontype,array('show','id'=>$model->idinteractiontype)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('interactiontype')); ?>:
<?php echo CHtml::encode($model->interactiontype); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>